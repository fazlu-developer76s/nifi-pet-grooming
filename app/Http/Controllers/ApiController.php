<?php

namespace App\Http\Controllers;

use App\Models\Kycprocess;
use App\Models\Package;
use App\Models\Pets;
use App\Models\Service;
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

    public function update_profile(Request $request)
    {
        $user = $request->user;
        $rules = array(
            'name'       => 'required',
            'email' => "required",
            'mobile'    => "required",
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        //     'mobile' => 'required|digits:10',
        //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        // ]);




        $exists = User::where(function ($query) use ($request, $user) {
            $query->where('email', $request->email)
                ->orWhere('mobile_no', $request->mobile);
        })
            ->where('id', '!=', $user->id)
            ->where('status', '!=', 3)
            ->exists();
        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or Mobile already exists'
            ], 422);
        }
        $user = User::find($request->user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_images'), $imageName);
            $user->image = 'uploads/profile_images/' . $imageName;
        }
        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile_no,
                    'image' => $user->image // Return full image URL
                ]
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Profile update failed. Please try again.'
        ], 500);
    }


    public function user_profile(Request $request)
    {
        $user_id = $request->user->id;
        $user_details = User::where('id', $user_id)
            ->first();
        $role_details = DB::table('roles')
            ->where('id', $request->user->role_id)
            ->where('status', 1)
            ->first();
        if ($user_details) {
            return response()->json([
                'status' => 'success',
                'message' => 'User profile',
                'data' => $user_details,
                'role' => $role_details->title,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 401);
        }
    }



    public function update_kyc(Request $request)
    {


        $user = $request->user;
        $user_id = $user->id;
        $user_update = Kycprocess::where('user_id', $user_id)->first();
        if (!$user_update) {
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
        return response()->json(['status' => 'OK', 'message' => "KYC updated successfully"]);
    }

    public function get_services()
    {
        $get_service = Service::where('status', 1)->get();
        if ($get_service) {
            return response()->json(['status' => 'Success', 'message' => 'Services fetched successfully', 'data' => $get_service]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No services found']);
        }
    }

    public function get_packages()
    {
        $get_package = Package::where('status', 1)->orderBy('id', 'desc')->get();
        $add_package_service = array();
        if (!empty($get_package)) {
            foreach ($get_package as $pack) {
                $pack->service = DB::table('add_package_service as a')->leftJoin('services as b', 'b.id', '=', 'a.service_id')->select('a.package_id', 'a.service_id', 'b.*')->where('a.status', 1)->where('b.status', 1)->where('a.package_id', $pack->id)->get();
                $pack->images = DB::table('packages_image')->where('status', 1)->where('package_id', $pack->id)->get();
                $add_package_service[] = $pack;
            }
        }

        if ($add_package_service) {
            return response()->json(['status' => 'Success', 'message' => 'Packages fetched successfully', 'data' => $add_package_service]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No packages found']);
        }
    }

    public function create_pet(Request $request)
    {
        // Define validation rules
        $rules = [
            'pet_name'   => 'required',
            'pet_image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender'     => 'required|string|max:255',
            'pet_type'   => 'required|string|max:255',
            'breed'      => 'required|string|max:255',
            'weight'     => 'required|integer',
            'age'         => 'required|integer',
            'aggression' => 'required|string|max:255',
            'vaccinated' => 'required|string',
        ];

        // Validate the request data
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }

        // Check for existing data
        $check_data = $this->check_exist_data($request, null);
        if ($check_data) {
            $message = '';
            if ($check_data->pet_name == $request->pet_name) {
                $message .= "Pet Category ";
            }
            if ($message) {
                return response()->json(['status' => 'Error', 'message' => $message . 'already exists.']);
            }
        }

        // Create a new Pets instance
        $pet = new Pets();
        $pet->user_id = $request->user->id;

        // Handle the pet image upload
        if ($request->hasFile('pet_image')) {
            $file = $request->file('pet_image');
            $filePath = $file->store('pet_category', 'public');
            $pet->image = $filePath;
        }

        // Assign additional fields
        $pet->gender = $request->gender;
        $pet->pet_name = $request->pet_name;
        $pet->pet_type = $request->pet_type;
        $pet->breed = $request->breed;
        $pet->weight = $request->weight;
        $pet->age = $request->age;
        $pet->aggression = $request->aggression;
        $pet->vaccinated = $request->vaccinated;

        // Save the new pet category
        $pet->save();

        return response()->json(['status' => 'OK', 'message' => "Pet added successfully"]);
    }


    public function list_pet(Request $request)
    {
        $get_pet = Pets::where('user_id', $request->user->id)->where('status', 1)->get();
        if ($get_pet) {
            return response()->json(['status' => 'Success', 'message' => 'Pet List Successfully', 'data' => $get_pet]);
        }
    }
    public function update_pet(Request $request, $id)
    {
        if (!$id) {
            return response()->json(['status' => 'Error', 'message' => 'Pet ID is required']);
        }
        if ($request->method() == "GET") {
            if (!empty($id)) {
                $get_single_pet = Pets::where('id', $id)->where('status', 1)->get();
                if ($get_single_pet) {
                    return response()->json(['status' => 'Success', 'message' => 'Single Pet Fetch Successfully', 'data' => $get_single_pet]);
                }
            }
        }

        if ($request->method() == "POST") {
            // Define validation rules
            $rules = [
                'pet_name'   => 'required',
                'pet_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gender'     => 'required|string|max:255',
                'pet_type'   => 'required|string|max:255',
                'breed'      => 'required|string|max:255',
                'weight'     => 'required|integer',
                'age'         => 'required|integer',
                'aggression' => 'required|string|max:255',
                'vaccinated' => 'required|string',
            ];

            // Validate the request data
            $validate = \Myhelper::FormValidator($rules, $request);
            if ($validate != "no") {
                return $validate;
            }

            // Check for existing data
            $check_data = $this->check_exist_data($request, $id);
            if ($check_data) {
                $message = '';
                if ($check_data->pet_name == $request->pet_name) {
                    $message .= "Pet Category ";
                }
                if ($message) {
                    return response()->json(['status' => 'ERR', 'message' => "Pet Category Already Exists"]);
                }
            }

            // Find the pet category by ID
            $pet = Pets::findOrFail($id);

            // Update the pet category details
            $pet->pet_name = $request->pet_name;
            $pet->user_id = $request->user->id;

            // Handle the pet image upload
            if ($request->hasFile('pet_image')) {
                $file = $request->file('pet_image');
                $filePath = $file->store('pet_category', 'public');
                $pet->image = $filePath;
            }

            // Assign additional fields
            $pet->gender = $request->gender;
            $pet->pet_type = $request->pet_type;
            $pet->breed = $request->breed;
            $pet->weight = $request->weight;
            $pet->age = $request->age;
            $pet->aggression = $request->aggression;
            $pet->vaccinated = $request->vaccinated;

            // Save the updated pet category
            $pet->save();

            return response()->json(['status' => 'OK', 'message' => "Pet Updated Successfully"]);
        }
    }

    public function create_booking(Request $request)
    {
        $rules = array(
            'package_id'       => 'required',
            'address_id'       => 'required',
            'booking_date'       => 'required',
            'booking_time'       => 'required',
        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $package_id = $request->package_id;
        $address_id = $request->address_id;
        $booking_date = $request->booking_date;
        $booking_time = $request->booking_time;
        $description  = $request->description;
        $get_address  = DB::table('tbl_address')->where('status', 1)->where('id', $address_id)->where('user_id', $request->user->id)->first();
        $insert_booking = DB::table('tbl_pet_bookings')->insert([
            'package_id' => $package_id,
            'booking_date' => $booking_date,
            'booking_time' => $booking_time,
            'description' => $description,
            'customer_id' => $request->user->id,
            'flat_house_no'         => $get_address->flat_house_no,
            'area_sector_locality'  => $get_address->area_sector_locality,
            'city_district'         => $get_address->city_district,
            'state'                 => $get_address->state,
            'pincode'               => $get_address->pincode,
            'complete_address'      => $get_address->complete_address,
            'email_address'         => $get_address->email_address
        ]);
        if ($insert_booking) {
            return response()->json(['status' => 'OK', 'message' => 'Booking created successfully']);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to create booking']);
        }
    }

    public function my_booking(Request $request)
    {
        $get_array = DB::table('tbl_pet_bookings as a')->select('a.*')->where('a.status', 1)->orderBy('a.id', 'desc')->get();
        return response()->json(['status' => 'OK', 'message' => 'Booking fetched successfully', 'data' => $get_array], 200);
    }

    public function fetch_booking(Request $request)
    {

        $booking = DB::table('pet_category')->where('user_id', $request->user->id)->where('status', 1)->orderBy('id', 'desc')->get();

        $get_array = array();
        if (!empty($booking)) {

            foreach ($booking as $book) {
                $book->get_booking = DB::table('tbl_pet_bookings as a')->join('users as b', 'a.customer_id', '=', 'b.id')->select('b.name as user_name', 'a.*')->where('a.status', 1)->where('b.status', 1)->orderBy('id', 'desc')->get();
                $get_array[] = $book;
            }

            return response()->json(['status' => 'OK', 'message' => 'Booking fetched successfully', 'data' => $get_array]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No booking found']);
        }
    }

    public function fetch_pet_category(Request $request)
    {

        $fetch_pet_category = DB::table('pet_category')->where('status', 1)->orderBy('id', 'desc')->get();
        if (!empty($fetch_pet_category)) {

            return response()->json(['status' => 'OK', 'message' => ' fetched Pet Category successfully', 'data' => $fetch_pet_category]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No booking found']);
        }
    }

    public function accept_booking(Request $request)
    {

        $rules = array(
            'id'       => 'required',
            'booking_status'       => 'required'
        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $booking_status_update = DB::table('tbl_pet_bookings')
            ->where('id', $request->id)
            ->update(['booking_status' => $request->booking_status]);
        return response()->json(['status' => 'OK', 'message' => 'Booking status updated successfully']);
    }

    public function check_exist_data($request, $id)
    {
        $query = Pets::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_pet_category = $query->where(function ($q) use ($request) {
            $q->where('pet_name', $request->pet_name)->where('user_id', $request->user->id);
        })->first();

        return $check_pet_category;
    }

    public function delete_pet(Request $request)
    {
        $update_pet_status = Pets::where('id', $request->id)->update(['status' => 3]);
        if ($update_pet_status) {
            return response()->json(['message' => 'Pet deleted successfully.'], 200);
        }
    }

    public function add_to_cart(Request $request, $id)
    {
        $check_cart = DB::table('tbl_cart')->where('user_id', $request->user->id)->where('service_id', $id)->first();
        if ($check_cart) {
            return response()->json(['message' => 'Service already added to cart.'], 200);
        }
        $add_cart = DB::table('tbl_cart')->insert(['user_id' => $request->user->id, 'service_id' => $id]);
        if ($add_cart) {
            return response()->json(['message' => 'Service added to cart successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to add service to cart.'], 500);
        }
    }
    public function get_cart_services(Request $request)
    {
        $cart_services = DB::table('tbl_cart as a')
            ->join('packages as b', 'a.service_id', '=', 'b.id')
            ->select('b.*', 'a.id as cart_id')->where('b.status', 1)
            ->get();
        return response()->json(['data' => $cart_services], 200);
    }
    public function delete_cart_service(Request $request, $id)
    {
        $delete_cart_service = DB::table('tbl_cart')->where('id', $id)->delete();
        if ($delete_cart_service) {
            return response()->json(['message' => 'Service deleted from cart successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete service from cart.'], 500);
        }
    }

    public function add_address(Request $request)
    {

        $rules = [
            'flat_house_no'         => 'required|string',
            'area_sector_locality'  => 'required|string',
            'city_district'         => 'required|string',
            'state'                 => 'required|string',
            'pincode'               => 'required|digits:6',
            'complete_address'      => 'required|string',
            'email_address'         => 'nullable|email'
        ];
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $inserted = DB::table('tbl_address')->insert([
            'user_id'               => $request->user->id,
            'flat_house_no'         => $request->flat_house_no,
            'area_sector_locality'  => $request->area_sector_locality,
            'city_district'         => $request->city_district,
            'state'                 => $request->state,
            'pincode'               => $request->pincode,
            'complete_address'      => $request->complete_address,
            'email_address'         => $request->email_address
        ]);
        if ($inserted) {
            return response()->json(['message' => 'Address added successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to add address.'], 500);
        }
    }

    public function get_address(Request $request)
    {
        $addresses = DB::table('tbl_address')->where('status', 1)->get();
        return response()->json(['data' => $addresses], 200);
    }

    public function delete_address(Request $request, $id)
    {
        $deleted = DB::table('tbl_address')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Address deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete address.'], 500);
        }
    }
}
