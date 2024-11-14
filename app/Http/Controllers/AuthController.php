<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'mobile_no' => [
                    'required',
                    'regex:/^[6-9][0-9]{9}$/',
                ],
                'email' => [
                    'required',
                    'email',
                ],
            ]);
            $user = User::where('email', $request->email)
                ->orWhere('mobile_no', $request->mobile_no)
                ->first();

            if ($user) {
                return response()->json([
                    'status' => "Error",
                    'message' => "Email or Mobile Number already exists",
                ], 409);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->status = 1;
            $user->role_id = $request->role_id;
            $user->created_at = now();
            $user->updated_at = now();
            $user->save();
            return response()->json([
                'status' => "OK",
                'message' => "User Created Successfully",
                'data' => $user,
            ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'mobile_no' => [
                'required',
                'regex:/^[6-9][0-9]{9}$/',
            ],
        ]);
        $request->validate([
            'mobile_no' => 'required',
        ]);
        $user = DB::table('users as a')->leftJoin('roles as b', 'a.role_id', 'b.id')->select('a.*', 'b.title as role_type')->where('a.mobile_no', $request->mobile_no)->first();
        if ($user) {
            if ($otp = $this->userOTP($request->mobile_no)) {
                $this->GenerateOTP($otp, $user->id);
                return response()->json([
                    'status' => "OK",
                    'message' => "login credentials is valid, OTP Send to your registered mobile no. Please Enter Otp to verify user",
                    'role'    => $user->role_id,
                    'role_type' => $user->role_type,
                    'data' => $request->all()
                ], 200);
            }
        }
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function user_otp(Request $request)
    {
        $validated = $request->validate([
            'mobile_no' => [
                'required',
                'regex:/^[6-9][0-9]{9}$/',
            ],
            'otp' => [
                'required',
                'integer',
                'digits:4',
            ],
        ]);
        $user = User::where('mobile_no', $request->mobile_no)->first();
        if ($user) {
            $getOTP = DB::table('tbl_otp')
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->where('otp', $request->otp)
                ->orderBy('id', 'desc')
                ->first();
            if (!$getOTP) {
                return response()->json([
                    'status' => "Error",
                    'message' => "Invalid OTP. Please Enter OTP",
                ], 401);
            } else {
                $current_time = Carbon::now();
                $otpTime = Carbon::parse($getOTP->created_at);
                if ($current_time->diffInMinutes($otpTime) > 10) {
                    return response()->json([
                        'status' => "Error",
                        'message' => "OTP is expired",
                        'data' => $request->all()
                    ], 401);
                }
                $this->ExpireOTP($user->id);
                $role_details = DB::table('roles')
                    ->where('id', $user->role_id)
                    ->where('status', 1)
                    ->first();

                $token = $this->createJwtToken($user, $role_details->title);
                if ($token) {
                    $this->ExpireToken($user->id);
                    $this->StoreToken($user->id, $token);
                }
                return response()->json([
                    'status' => "OK",
                    'token' => $token,
                    'user' => $user,
                    'role' => $role_details->title
                ], 200);
            }
        }
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function resend_otp(Request $request)
    {
        $request->validate([
            'aadhar_no' => 'required',
            'mobile_no' => 'required',
        ]);
        if (strlen($request->aadhar_no) != 12) {
            return response()->json([
                'status' => "Error",
                'message' => "Please Enter 12 Digit Aadhar No",
                'data' => $request->all()
            ], 401);
        }

        if (strlen($request->mobile_no) != 10) {
            return response()->json([
                'status' => "Error",
                'message' => "Please Enter 10 Digit Mobile No",
                'data' => $request->all()
            ], 401);
        }

        // Find the user by email
        $user = User::where('aadhar_no', $request->aadhar_no)
            ->where('mobile_no', $request->mobile_no)
            ->first();

        if ($user) {
            if ($otp = $this->userOTP($request->mobile_no)) {
                $this->ExpireOTP($user->id);
                $this->GenerateOTP($otp, $user->id);
                return response()->json([
                    'status' => "OK",
                    'message' => "OTP Resend Successfully",
                    'data' => $request->all()
                ], 200);
            }
        }

        if (!$user) {
            return response()->json([
                'status' => "Error",
                'message' => "Invalid Credentials",
                'data' => $request->all()
            ], 401);
        }
    }
    private function createJwtToken($user, $role)
    {
        $key = env('JWT_SECRET');  // Secret key
        $payload = [
            'role' => $role, // Issuer of the token
            'sub' => $user->id,           // Subject of the token (user ID)
            'iat' => time(),              // Issued at time
            'exp' => time() + 60 * 60       // Expiration time (1 hour)
        ];

        // Encode the token
        return JWT::encode($payload, $key, 'HS256');
    }
    public function userOTP($mobile_no)
    {
        $otp = 1234;
        return $otp;
        $entity_id = 1701159540601889654;
        $senderId  = "NRSOFT";
        $temp_id   = "1707164805234023036";
        $userid = "NERASOFT1";
        $otp = rand(1000, 9999);
        $request = "Login Request";
        $password = 111321;
        $temp = "Dear User Your OTP For Login in sixcash is $otp Valid For 10 Minutes. we request you to don't share with anyone .Thanks NSAFPL";
        $url = 'http://sms.nerasoft.in/api/SmsApi/SendSingleApi?' . http_build_query([
            'UserID'    => $userid,
            'Password'  => $password,
            'SenderID'  => $senderId,
            'Phno'      => $mobile_no,
            'Msg'       => $temp,
            'EntityID'  => $entity_id,
            'TemplateID' => $temp_id
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Content-Type: application/json',
            'Content-Length: 0'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return "Error: $error";
        }
        curl_close($ch);
        return $otp;
    }


    public function ExpireOTP($user_id)
    {
        $expireOTP = DB::table('tbl_otp')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->where('module_type', 1)
            ->where('otp_type', 1)
            ->update(['status' => 2]);
        if ($expireOTP) {
            return true;
        }
    }

    public function GenerateOTP($otp, $user_id)
    {
        $genrateOTP = DB::table('tbl_otp')->insert([
            'otp' => $otp,
            'user_id' => $user_id, // Assuming you want to associate the OTP with a user
            'created_at' => now(), // Current timestamp
            'updated_at' => now(),
        ]);
        if ($genrateOTP) {
            return true;
        }
    }

    public function StoreToken($user_id, $token)
    {
        $storeToken = DB::table('tbl_token')->insert([
            'user_id' => $user_id, // Assuming you want to associate the token with a user
            'token' => $token, // Generate a unique token for each user
            'created_at' => now(), // Current timestamp
            'updated_at' => now(),
            'status' => 1, // Token status (1: active, 2: expired)
        ]);
    }

    public function CheckToken($user_id, $token)
    {
        $checkToken = DB::table('tbl_token')
            ->where('user_id', $user_id)
            ->where('token', $token)
            ->where('status', 1)
            ->first();
        if ($checkToken) {
            return true;
        } else {
            return false;
        }
    }

    public function ExpireToken($user_id)
    {
        $expireToken = DB::table('tbl_token')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->update(['status' => 2, 'updated_at' => now()]);
        if ($expireToken) {
            return true;
        }
    }

    public function user_logout(Request $request)
    {

        $user_id = $request->user->id;
        $this->ExpireToken($user_id);
        return response()->json([
            'status' => "OK",
            'message' => "User Logout Successfully"
        ], 200);
    }

    public function create_pin(Request $request)
    {
        $request->validate([
            'pin' => 'required',
        ]);
        if (strlen($request->pin) != 4) {
            return response()->json([
                'status' => "Error",
                'message' => "Please Enter 4 Security PIN",
                'data' => $request->all()
            ], 401);
        }
        $user_id = $request->user->id;
        if ($this->update_pin($request->pin, $user_id)) {
            return response()->json([
                'status' => "OK",
                'message' => "User Security PIN Created/Updated Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => "Error",
                'message' => "Failed to Update Pin",
                'data' => $request->all()
            ], 401);
        }
    }

    public function update_pin($pin, $user_id)
    {
        $updatePin = User::where('id', $user_id)
            ->update(['security_pin' => $pin]);
        if ($updatePin) {
            return true;
        } else {
            return false;
        }
    }

    public function getTokenStatus(Request $request)
    {
        $token = $request->token;
        $checkToken = DB::table('tbl_token')
            ->where('token', $token)
            ->orderBy('id', 'desc')
            ->first();
        if ($checkToken) {
            if ($checkToken->status == 1) {
                return response()->json([
                    'status' => "OK",
                    'message' => "Token is Active",
                    'data' => $request->all()
                ], 200);
            } else {
                return response()->json([
                    'status' => "Error",
                    'message' => "Token is Expired or Invalid",
                    'data' => $request->all()
                ], 401);
            }
        } else {
            return response()->json([
                'status' => "Error",
                'message' => "Invalid Token",
                'data' => $request->all()
            ], 401);
        }
    }

    public function referal(Request $request){
        $user = $request->user;
        if($user->role_id == 5){
            $user_type = 2;
        }
        if($user->role_id == 3){
            $user_type = 1;
        }
        if($user->role_id != 5 && $user->role_id !=3){
            return response()->json([
               'status' => 'error',
               'message' => 'You Dont have permission to refer user'
            ], 401);
        }
        $referral_code = strtoupper(uniqid($user->id));
        DB::table('referral_code')->insert(['user_id'=>$user->id,'code'=>$referral_code,'user_type'=>$user_type]);
        $referralUrl = route('referaluser') . '?referral_code=' . $referral_code;
        return response()->json([
            'status' => 'success',
            'referral_url' => $referralUrl,
        ]);
    }

    public function register_referral_user(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'referral_code' => 'required',
            'mobile_no' => [
                'required',
                'regex:/^[6-9][0-9]{9}$/',
            ],
            'email' => [
                'required',
                'email',
            ],
        ]);
        $referralCode = DB::table('referral_code')->where('code', $request->referral_code)->first();
        $get_user = User::find($referralCode->id);
        $parent_id = $get_user->id;
        $user = User::where('email', $request->email)
            ->orWhere('mobile_no', $request->mobile_no)
            ->first();

        if ($user) {
            return response()->json([
                'status' => "Error",
                'message' => "Email or Mobile Number already exists",
            ], 409);
        }
        $user = new User();
        $user->parent_id = $parent_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        $user->status = 1;
        $user->role_id = $request->role_id;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        return response()->json([
            'status' => "OK",
            'message' => "User Created Successfully",
            'data' => $user,
        ], 201);
    }

}
