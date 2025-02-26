<?php

namespace App\Http\Controllers;

use App\Models\Kycprocess;
use App\Models\Package;
use App\Models\Page;
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
        // encrypt
        $user_data = array(
            "p1" => $post->register_aadhar,
            "p2" => rand(0000000000,9999999999)
        );
        $urls = "https://api.nifipayments.com/api/user/encrypt";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "x-api-iv: 58e45c94e3c0707abbe7ae9f12f4fff2",
            "x-api-key: d1ef40c68da4df29e4a28df898c13b636748f6c56d3290027cf5946ca06f794a"
        ];
        $encrypt_data = \Myhelper::curl($urls, "POST", json_encode($user_data), $headers, "yes", "report");
        // encrypt
        $aadharRecord = \DB::table("kycdatas")->where("type", "aadhar")->where('number', $post->register_aadhar)->first();
        if (!$aadharRecord) {
            $url = "https://api.nifipayments.com/api/v1/validate/aadhar/advance";
            $header = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'x-client-id: e26c92f1fb5a0b937a125b4797c8e42d',
                'x-api-key: 9efb1d0446137c4be81c06ddad6de420041000e0acd4baeaf03bfe624d7dbd0e',
            );
            $parameter['body'] = json_decode($encrypt_data['response'])->body;
            $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "report", $post->register_aadhar);

            // decrypt
            $urls1 = "https://api.nifipayments.com/api/user/decryptReq";
            $user_data1 = array(
                "body" => json_decode($result['response'])->body
            );
            $decrypt_data = \Myhelper::curl($urls1, "POST", json_encode($user_data1), $headers, "yes", "report");
            // decrypt

            if ($decrypt_data != "") {
                $response = json_decode($decrypt_data['response'])->body;
                $response1 =json_decode($response);
                if (isset($response1->data->data->otp_sent) && $response1->data->data->otp_sent === true) {
                    return response()->json(['status' => 'TXNOTP', 'message' => "Aadhar verify successfully", "client_id" => $response1->data->transaction_id]);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => isset($response1->message) ? $response1->message : "Please contact your administrator"]);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Please contact your administrator"]);
            }
        }
         else {
            $response = json_decode($aadharRecord->response);
            return response()->json([
                'status'  => 'success',
                'message' => "Aadhar verified successfully",
                "response" => $aadharRecord->response
                // 'message' => "Aadhar re-verified successfully",
                // "profile" => "data:image/png;base64, " . $response->profile_image,
                // "mobile"  => $aadharRecord->mobile,
                // 'state'   => $response->address->state,
                // 'pincode' => $response->zip,
                // 'city'    => $response->address->po,
                // 'address' => $response->address->house . " " . $response->address->street . " " . $response->address->loc
            ]);
        }
    }

    public function checkaadharotp(Request $post)
    {
        $rules = array(
            'otp'       => 'required',
            'client_id' => "required",
            // 'mobile'    => "required"
        );
        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }

        // encrypt
        $user_data = array(
        "p1" => $post->client_id,
        "p2" => $post->otp
        );
        $urls = "https://api.nifipayments.com/api/user/encrypt";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "x-api-iv: 58e45c94e3c0707abbe7ae9f12f4fff2",
            "x-api-key: d1ef40c68da4df29e4a28df898c13b636748f6c56d3290027cf5946ca06f794a"
        ];
        $encrypt_data = \Myhelper::curl($urls, "POST", json_encode($user_data), $headers, "yes", "report");

        // encrypt
        $url = "https://api.nifipayments.com/api/v1/validate/otp-submit/advance";
        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'x-client-id: e26c92f1fb5a0b937a125b4797c8e42d',
            'x-api-key: 9efb1d0446137c4be81c06ddad6de420041000e0acd4baeaf03bfe624d7dbd0e',
        );

        $parameter['body'] = json_decode($encrypt_data['response'])->body;
        $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "report");

        // decrypt
        $urls1 = "https://api.nifipayments.com/api/user/decryptReq";
        $user_data1 = array(
            "body" => json_decode($result['response'])->body
        );
        $decrypt_data = \Myhelper::curl($urls1, "POST", json_encode($user_data1), $headers, "yes", "report");
        // decrypt
        if ($decrypt_data != "") {
            $response = json_decode($decrypt_data['response'])->body;
            $response1 =json_decode($response);
            if (isset($response1->status) && $response1->status === 'success') {

                \DB::table("kycdatas")->insert([
                    "type"   => "aadhar",
                    "name"   => $response1->data->full_name,
                    "number" => $response1->data->aadhaar_number,
                    "mobile" => $post->mobile,
                    "state"  => $post->client_id,
                    "response" => json_encode($response1->data),
                    'user_id' => \Auth::id()
                ]);
                return response()->json([
                    'status'  => 'success',
                    'message' => "Aadhar verified successfully",
                    // "profile" => "data:image/png;base64, " . $response1->data->profile_image,
                    // "mobile"  => $post->mobile,
                    // "number" => $response1->data->aadhaar_number,
                    // "name"   => $response1->data->full_name,
                    // 'state'   => $response1->data->address->state,
                    // 'pincode' => $response1->data->zip,
                    // 'city'    => $response1->data->address->po,
                    // 'address' => $response1->data->address->house . " " . $response1->data->address->street . " " . $response1->data->address->landmark . " " . $response1->data->address->loc,
                    "response" => json_encode($response1->data)
                ]);
            } else {
                return response()->json(['status' => 'ERR', 'message' => isset($response1->message) ? $response1->message : "Please contact your administrator"]);
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

    public function get_kyc(Request $request){
        $user_id = $request->user->id;
        $kyc_details = Kycprocess::where('user_id', $user_id)->first();
        // $kyc_details = DB::table('kycdatas')->where('user_id', $user_id)->first();
        if ($kyc_details) {
            return response()->json([
               'status' =>'success',
               'message' => 'KYC details',
                'data' => $kyc_details
            ], 200);
        } else {
            return response()->json([
               'status' => 'error',
               'message' => 'KYC details not found'
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
        if ($request->name) {
            $user_update->name = $request->name;
        }

        if ($request->mobile_no) {
            $user_update->mobile_no = $request->mobile_no;
        }

        if ($request->email) {
            $user_update->email = $request->email;
        }

        if ($request->date_of_birth) {
            $user_update->date_of_birth = $request->date_of_birth;
        }

        if ($request->gender) {
            $user_update->gender = $request->gender;
        }

        if ($request->is_personal_verified) {
            $user_update->is_personal_verified = $request->is_personal_verified;
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


        if (!empty($request->lat) && !empty($request->long)) {
            $apiKey = '9d52cf15543e4b1d9517f51ba60e6961';
            $url = "https://api.opencagedata.com/geocode/v1/json?q={$request->lat}+{$request->long}&key={$apiKey}";
            $response = file_get_contents($url);
            $responseData = json_decode($response, true);

            if (!empty($responseData['results'])) {
                $addressComponents = $responseData['results'][0]['components'];
                $user_update->normalized_city = $addressComponents['city'] ?? null;
                $user_update->category = $addressComponents['_category'] ?? 'road';
                $user_update->type = $addressComponents['_type'] ?? 'road';
                $user_update->continent = $addressComponents['continent'] ?? null;
                $user_update->country = $addressComponents['country'] ?? null;
                $user_update->country_code = $addressComponents['country_code'] ?? null;
                $user_update->county = $addressComponents['county'] ?? null;
                $user_update->postcode = $addressComponents['postcode'] ?? null;
                $user_update->road = $addressComponents['road'] ?? 'unnamed road';
                $user_update->road_type = $addressComponents['road_type'] ?? 'residential';
                $user_update->state = $addressComponents['state'] ?? null;
                $user_update->state_code = $addressComponents['state_code'] ?? null;
                $user_update->state_district = $addressComponents['state_district'] ?? null;
                $user_update->suburb = $addressComponents['suburb'] ?? null;
            }
        }
        if ($request->is_current_location_verified) {
            $user_update->is_current_location_verified = $request->is_current_location_verified;
        }

        if ($request->hasFile('equipment_image')) {
            $file = $request->file('equipment_image');
            $filePath = $file->store('kyc', 'public');
            $user_update->equipment_image = $filePath;
        }
        if ($request->is_equipment_verified) {
            $user_update->is_equipment_verified = $request->is_equipment_verified;
        }

        if ($request->hasFile('live_photo')) {
            $file = $request->file('live_photo');
            $filePath = $file->store('kyc', 'public');
            $user_update->live_photo = $filePath;
        }
        if ($request->is_live_photo_verified) {
            $user_update->is_live_photo_verified = $request->is_live_photo_verified;
        }
        if ($request->hasFile('live_video')) {
            $file = $request->file('live_video');
            $filePath = $file->store('kyc', 'public');
            $user_update->live_video = $filePath;
        }
        if ($request->is_live_video_verified) {
            $user_update->is_live_video_verified = $request->is_live_video_verified;
        }
        if ($request->step) {
            $user_update->step = $request->step;
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
            'age'         => 'required',
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
            'booking_amount'       => 'required',
            'tax_amount'       => 'required',
            'total_amount'       => 'required',
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
        $booking_amount  = $request->booking_amount;
        $tax_amount  = $request->tax_amount;
        $total_amount  = $request->total_amount;
        $get_address  = DB::table('tbl_address')->where('status', 1)->where('id', $address_id)->where('user_id', $request->user->id)->first();
        $insert_booking = DB::table('tbl_pet_bookings')->insert([
            'package_id' => $package_id,
            'booking_date' => $booking_date,
            'booking_time' => $booking_time,
            'booking_amount' => $booking_amount,
            'tax_amount' => $tax_amount,
            'total_amount' => $total_amount,
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
            return response()->json(['status' => 'OK', 'message' => 'Pet deleted successfully.'], 200);
        }
    }

    public function add_to_cart(Request $request, $id, $price)
    {
        $check_cart = DB::table('tbl_cart')->where('user_id', $request->user->id)->where('service_id', $id)->first();
        if ($check_cart) {
            $add_cart = DB::table('tbl_cart')
                ->where('id', $check_cart->id)
                ->update(['price' => $price]);
            return response()->json(['status' => 'Exist', 'message' => 'Service already added to cart.'], 200);
        }
        $add_cart = DB::table('tbl_cart')->insert(['user_id' => $request->user->id, 'price' => $price, 'service_id' => $id]);
        if ($add_cart) {
            return response()->json(['status' => 'OK', 'message' => 'Service added to cart successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to add service to cart.'], 501);
        }
    }
    public function get_cart_services(Request $request)
    {
        $cart_services = DB::table('tbl_cart as a')
            ->join('packages as b', 'a.service_id', '=', 'b.id')
            ->select('b.*', 'a.id as cart_id', 'a.price as price')->where('b.status', 1)
            ->get();
        return response()->json(['status' => 'OK', 'data' => $cart_services], 200);
    }
    public function delete_cart_service(Request $request, $id)
    {
        $delete_cart_service = DB::table('tbl_cart')->where('id', $id)->delete();
        if ($delete_cart_service) {
            return response()->json(['status' => 'OK', 'message' => 'Service deleted from cart successfully.'], 200);
        } else {
            return response()->json(['status' => 'OK', 'message' => 'Failed to delete service from cart.'], 500);
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
            return response()->json(['status' => 'OK', 'message' => 'Address added successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to add address.'], 500);
        }
    }

    public function get_address(Request $request)
    {
        $addresses = DB::table('tbl_address')->where('status', 1)->get();
        return response()->json(['status' => 'OK', 'data' => $addresses], 200);
    }

    public function delete_address(Request $request, $id)
    {
        $deleted = DB::table('tbl_address')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['status' => 'OK', 'message' => 'Address deleted successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to delete address.'], 500);
        }
    }

    public function get_location(Request $request)
    {
        $rules = [
            'lat'         => 'required|string',
            'long'  => 'required|string'
        ];
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $apiKey = '9d52cf15543e4b1d9517f51ba60e6961';
        $url = "https://api.opencagedata.com/geocode/v1/json?q={$request->lat}+{$request->long}&key={$apiKey}";
        $response = file_get_contents($url);
        $responseData = json_decode($response, true);
        if (!empty($responseData['results'])) {
            $location = $responseData['results'][0]['formatted'];
            return response()->json(['status' => 'OK', 'data' => $responseData], 200);
        } else {
            return response()->json(['status' => 'Error', 'data' => 'Location not found.'], 404);
        }
    }

    public function update_current_location(Request $request)
    {
        $user = User::findOrFail($request->user->id);
        if (!empty($request->lat) && !empty($request->long)) {
            $apiKey = '9d52cf15543e4b1d9517f51ba60e6961';
            $url = "https://api.opencagedata.com/geocode/v1/json?q={$request->lat}+{$request->long}&key={$apiKey}";
            $response = file_get_contents($url);
            $responseData = json_decode($response, true);

            if (!empty($responseData['results'])) {
                $addressComponents = $responseData['results'][0]['components'];
                $user->_normalized_city = $addressComponents['city'] ?? null;
                $user->_category = $addressComponents['_category'] ?? 'road';
                $user->_type = $addressComponents['_type'] ?? 'road';
                $user->continent = $addressComponents['continent'] ?? null;
                $user->country = $addressComponents['country'] ?? null;
                $user->country_code = $addressComponents['country_code'] ?? null;
                $user->county = $addressComponents['county'] ?? null;
                $user->postcode = $addressComponents['postcode'] ?? null;
                $user->road = $addressComponents['road'] ?? 'unnamed road';
                $user->road_type = $addressComponents['road_type'] ?? 'residential';
                $user->state = $addressComponents['state'] ?? null;
                $user->state_code = $addressComponents['state_code'] ?? null;
                $user->state_district = $addressComponents['state_district'] ?? null;
                $user->suburb = $addressComponents['suburb'] ?? null;
            }
        }
        $user->save();
        return response()->json(['status' => 'OK', 'message' => 'Profile updated successfully'], 200);
    }

    public function get_pages(Request $request, $title)
    {
        $page = Page::where('page_name', $title)->first();
        if ($page) {
            return response()->json(['status' => 'OK', 'data' => $page], 200);
        } else {
            return response()->json(['status' => 'Error', 'data' => 'Page not found.'], 404);
        }
    }
}
