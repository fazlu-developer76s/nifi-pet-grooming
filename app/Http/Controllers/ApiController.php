<?php

namespace App\Http\Controllers;

use App\Models\Kycprocess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function get_aadhar_otp(Request $post)
    {
        $rules = array(
            'register_aadhar' => 'required'
        );
        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }
        $aes_key = "3c8cdd3e3028795dacf67ef25a89509a989768b067a7b591cc468954ad4e1620";
        $aes_iv = "ec5bad40b2162069";
        $user_data = array(
            'p1' => "Advance",
            "p2" => $post->register_aadhar,
            "p3" => "sdfgs6848"
        );
        $encrypt_data = \Myhelper::newEncrypt(json_encode($user_data), $aes_key, $aes_iv);
        $aadharRecord = \DB::table("kycdatas")->where("type", "aadhar")->where('number', $post->register_aadhar)->first();
        if (!$aadharRecord) {
            $url = "http://192.168.0.181:8000/api/v1/validate/aadhar";
            $header = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'client_id: 98dfe4dbc68bb6948a85137927f857e0',
                'x-api-key: 596e6fc87495e86afb31437b866cce1e00a1248169a90f0fa8eefc230a0b7af4',
            );
            $parameter['body'] = $encrypt_data;
            $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "report", $post->register_aadhar);
            $dec_res = json_decode($result['response']);
            $decrypt_data = \Myhelper::newDecrypt($dec_res->body, $aes_key, $aes_iv);
            if ($decrypt_data != "") {
                $response = json_decode($decrypt_data);
                if (isset($response->data->data->otp_sent) && $response->data->data->otp_sent === true) {
                    return response()->json(['status' => 'TXNOTP', 'message' => "Aadhar verify successfully", "client_id" => $response->data->transaction_id]);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => isset($response->message) ? $response->message : "Please contact your administrator"]);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Please contact your administrator"]);
            }
        } else {
            $response = json_decode($aadharRecord->response);
            return response()->json([
                'status'  => 'TXN',
                'message' => "Aadhar re-verified successfully",
                "profile" => "data:image/png;base64, " . $response->profile_image,
                "mobile"  => $aadharRecord->mobile,
                'state'   => $response->address->state,
                'pincode' => $response->zip,
                'city'    => $response->address->po,
                'address' => $response->address->house . " " . $response->address->street . " " . $response->address->loc
            ]);
        }
    }

    public function checkaadharotp(Request $post)
    {
        $rules = array(
            'otp'       => 'required',
            'client_id' => "required",
            'mobile'    => "required"
        );
        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }
        $aes_key = "3c8cdd3e3028795dacf67ef25a89509a989768b067a7b591cc468954ad4e1620";
        $aes_iv = "ec5bad40b2162069";
        $user_data = array(
            'p1' => "Advance",
            "p2" => $post->otp,
            "p3" => $post->client_id
        );
        $encrypt_data = \Myhelper::newEncrypt(json_encode($user_data), $aes_key, $aes_iv);
        $url = "http://192.168.0.181:8000/api/v1/validate/otp-submit";
        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'client_id: 98dfe4dbc68bb6948a85137927f857e0',
            'x-api-key: 596e6fc87495e86afb31437b866cce1e00a1248169a90f0fa8eefc230a0b7af4',
        );
        $parameter['body'] = $encrypt_data;
        $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "report", $post->mobile);
        $dec_res = json_decode($result['response']);
        $decrypt_data = \Myhelper::newDecrypt($dec_res->body, $aes_key, $aes_iv);
        if ($decrypt_data != "") {
            $response = json_decode($decrypt_data);
            if (isset($response->status) && $response->status === true) {
                \DB::table("kycdatas")->insert([
                    "type"   => "aadhar",
                    "name"   => $response->data->data->full_name,
                    "number" => $response->data->data->aadhaar_number,
                    "mobile" => $post->mobile,
                    "state"  => $post->client_id,
                    "response" => json_encode($response->data),
                    'user_id' => \Auth::id()
                ]);
                return response()->json([
                    'status'  => 'TXN',
                    'message' => "Aadhar verified successfully",
                    "profile" => "data:image/png;base64, " . $response->data->data->profile_image,
                    "mobile"  => $post->mobile,
                    'state'   => $response->data->data->address->state,
                    'pincode' => $response->data->data->zip,
                    'city'    => $response->data->data->address->po,
                    'address' => $response->data->data->address->house . " " . $response->data->data->address->street . " " . $response->data->data->address->landmark . " " . $response->data->data->address->loc
                ]);
            } else {
                return response()->json(['status' => 'ERR', 'message' => isset($response->message) ? $response->message : "Please contact your administrator"]);
            }
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Please contact your administrator"]);
        }
    }

    public function update_kyc(Request $request)
    {
        $user = $request->user;
        $user_id = $user->id;
        $user_update = Kycprocess::where('user_id',$user_id)->first();
        if(!$user_update){
            $user_update = new Kycprocess();
            $user_update->kyc_status = 1;
            $user_update->user_id = $user_id;
        }
        if ($request->aadhar_no) {
            $user_update->aadhar_no = $request->aadhar_no;
        }
        if ($request->aadhar_name) {
            $user_update->aadhar_name = $request->aadhar_name;
        }
        if ($request->aadhar_father_name) {
            $user_update->aadhar_father_name = $request->aadhar_father_name;
        }
        if ($request->aadhar_dob) {
            $user_update->aadhar_dob = $request->aadhar_dob;
        }
        if ($request->aadhar_zipcode) {
            $user_update->aadhar_zipcode = $request->aadhar_zipcode;
        }
        if ($request->aadhar_country) {
            $user_update->aadhar_country = $request->aadhar_country;
        }
        if ($request->aadhar_state) {
            $user_update->aadhar_state = $request->aadhar_state;
        }
        if ($request->aadhar_city) {
            $user_update->aadhar_city = $request->aadhar_city;
        }
        if ($request->aadhar_address) {
            $user_update->aadhar_address = $request->aadhar_address;
        }
        if ($request->aadhar_profile_photo) {
            $user_update->aadhar_profile_photo = $request->aadhar_profile_photo;
        }
        if ($request->aadhar_mobile_no) {
            $user_update->aadhar_mobile_no = $request->aadhar_mobile_no;
        }
        if ($request->is_aadhar_verified) {
            $user_update->is_aadhar_verified = $request->is_aadhar_verified;
        }
        if ($request->pan_no) {
            $user_update->pan_no = $request->pan_no;
        }
        if ($request->pan_name) {
            $user_update->pan_name = $request->pan_name;
        }
        if ($request->is_pan_verified) {
            $user_update->is_pan_verified = $request->is_pan_verified;
        }
        if ($request->ifsc_code) {
            $user_update->ifsc_code = $request->ifsc_code;
        }
        if ($request->account_no) {
            $user_update->account_no = $request->account_no;
        }
        if ($request->bank_name) {
            $user_update->bank_name = $request->bank_name;
        }
        if ($request->account_holder_name) {
            $user_update->account_holder_name = $request->account_holder_name;
        }
        if ($request->is_bank_verified) {
            $user_update->is_bank_verified = $request->is_bank_verified;
        }
        if ($request->hasFile('live_photo')) {
            $file = $request->file('live_photo');
            $filePath = $file->store('kyc', 'public');
            $user_update->live_photo = $filePath;
        }
        if ($request->hasFile('live_video')) {
            $file = $request->file('live_video');
            $filePath = $file->store('kyc', 'public');
            $user_update->live_video = $filePath;
        }
        $user_update->save();
            return response()->json(['status' => 'OK','message' => "KYC updated successfully"]);

    }
}
