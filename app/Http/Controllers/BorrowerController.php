<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use App\Helpers\Global_helper as GlobalHelper;
use App\Services\PHPMailerService;
use DB;
use Carbon\Carbon;

class BorrowerController extends Controller
{
    //
    protected $mailService;

    public function __construct(PHPMailerService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function update_email_mobile_request(Request $request)
    {
       if($request->user->role_id!=3)
       {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized Access.You are not allowed to update your mobile or email address.',
            'StatusCode' => 403
        ]);
       }
       $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
       
       if(preg_match($regex, $request->field_value))
       {
           $user_details = $this->getUserDetails($request->user->id, $request->field_value, 'email');
           if($user_details){
             // $module_type = 2 for update mobile or email address
             // $otp_type =  1 - mobile otp, 2 for email otp
             $module_type = 2;
             $otp_type = 2;
            if($email_temp = GlobalHelper::GenerateEmailOTP($request->user, $module_type, $otp_type))
            {
             $this->mailService->sendEmail($email_temp['to'], $email_temp['subject'], $email_temp['body']);
                return response()->json([
                   'status' => 'success',
                   'message' => 'OTP sent to your registered email',
                   'data' => $request->all()
                ]);
            }
            else
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'Failed to send OTP. Please try again later.',
                   'data' => $request->all()
                ]);
            }
           }
           else
           {
             return response()->json([
                   'status' => 'error',
                   'message' => 'Invalid Email Id. Please Enter Registered Email Id',
                   'data' => $request->all()
                ]);
           }
           
       }
       else
       {
           $user_details = $this->getUserDetails($request->user->id, $request->field_value, 'mobile');
           if($user_details){
            $module_type = 2;
            $otp_type = 1;
           if(GlobalHelper::GenerateOTP($request->user, $module_type, $otp_type))
           {
               return response()->json([
                  'status' => 'success',
                  'message' => 'OTP sent to your registered mobile',
                  'data' => $request->all()
               ]);
           }
           else
           {
               return response()->json([
                  'status' => 'error',
                  'message' => 'Failed to send OTP. Please try again later.',
                  'data' => $request->all()
               ]);
           }
           }
           else
           {
             return response()->json([
                  'status' => 'error',
                  'message' => 'Invalid Mobile Number. Please Enter Registered Mobile Number',
                  'data' => $request->all()
               ]);
           }
       }

    }
      
        public function getUserDetails($user_id,$field_value, $field_type)
        {
            $query = User::where('status', 1)
                 ->where('id', $user_id);

            // Add condition based on the field type
            if ($field_type == 'mobile') {
                $query->where('mobile_no', $field_value);
            } else {
                $query->where('email', $field_value);
            }

            // Fetch the first user matching the query
            $user = $query->first();

            if($user){
                return true;
            }
            else{
                return false;
            }
        }
       
        public function update_new_email_mobile_request(Request $request)
        {
            $otp = $request->otp;
            $field_value = $request->field_value;
            $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            
            $checkUser = (preg_match($regex, $field_value)) ? $this->checkUser($request->user->id, $request->field_value,2) : $this->checkUser($request->user->id, $request->field_value,1);
            if($checkUser)
            {
                   return response()->json([
                       'status' => 'error',
                       'message' => 'Email or Mobile already exists',
                       'StatusCode' => 202
                    ]);
            }
            if(preg_match($regex, $field_value))
            {
                $module_type = 2;
                $otp_type = 2;
                $otp_details = $this->otpVerify($request->user->id, $otp, $otp_type, $module_type);
                if($otp_details)
                {
                 $current_time = Carbon::now();
                 $otpTime = Carbon::parse($otp_details->created_at); // Convert to a Carbon instance
                 if ($current_time->diffInMinutes($otpTime) > 10) {
                     return response()->json([
                         'status' => "Error",
                         'message' => "OTP is expired",
                         'data' => $request->all()
                     ]);
                 }
                 else
                 {
                     if($email_temp = GlobalHelper::GenerateEmailOTP($request->user, $module_type, $otp_type, $field_value))
                         {
                            $this->mailService->sendEmail($email_temp['to'], $email_temp['subject'], $email_temp['body']);
                             return response()->json([
                                 'status' => 'success',
                                 'message' => 'OTP sent to your email address',
                                 'StatusCode' => 200
                             ]);
                         }
                         else
                         {
                             return response()->json([
                                 'status' => 'error',
                                 'message' => 'Failed to send OTP. Please try again later.',
                                 'data' => $request->all()
                             ]);
                         }
                 }
                }
                else
                {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP. Please Enter Correct OTP.',
                    'data' => $request->all()
                 ]);
                }
             }
              
            else
            {
                $module_type = 2;
                $otp_type = 1;
               $otp_details = $this->otpVerify($request->user->id, $otp, $otp_type, $module_type);
               if($otp_details)
               {
                $current_time = Carbon::now();
                $otpTime = Carbon::parse($otp_details->created_at); // Convert to a Carbon instance
                if ($current_time->diffInMinutes($otpTime) > 10) {
                    return response()->json([
                        'status' => "Error",
                        'message' => "OTP is expired",
                        'data' => $request->all()
                    ]);
                }
                else
                {
                    if(GlobalHelper::GenerateOTP($request->user, $module_type, $otp_type, $request->field_value))
                        {
                            return response()->json([
                                'status' => 'success',
                                'message' => 'OTP sent to your mobile',
                                'StatusCode' => 200
                            ]);
                        }
                        else
                        {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Failed to send OTP. Please try again later.',
                                'data' => $request->all()
                            ]);
                        }
                }
               }
               else
               {
                return response()->json([
                   'status' => 'error',
                   'message' => 'Invalid OTP. Please Enter Correct OTP.',
                   'data' => $request->all()
                ]);
               }
            }

        }

        public function otpVerify($user_id, $otp, $otp_type, $module_type)
        {
          $query = DB::table('tbl_otp')
            ->where('user_id', $user_id)
            ->where('status',1)
            ->where('module_type',$module_type)
            ->where('otp_type',$otp_type)
            ->where('otp',$otp)
            ->orderBy('id',"desc")
            ->first();
         
           return $query;
          
        }

        public function checkUser($user_id, $field_value, $field_type)
        {
             $query = User::where('status', 1)
                 ->where('id', '!=', $user_id);
             if($field_type==1)
             {
                 $query->where('mobile_no', $field_value);
             }
             else
             {
                 $query->where('email', $field_value);
             }
             $user = $query->first();
            
             return $user;

            // Add condition based on the field type
        }

        public function update_profile(Request $request)
        {
            $request->validate([
                'field_value' => 'required',
                'otp' => 'required'
            ]);
            $field_value = $request->field_value;
            $otp = $request->otp;
            $otpVerify = $this->otpVerifyByField($request->user->id, $field_value, $otp);
            if(!$otpVerify)
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'Invalid OTP. Please Enter Correct OTP.',
                    'StatusCode' => 202
                ]);
            }
            else
            {
                GlobalHelper::ExpireOTP($request->user->id,$otpVerify->module_type,$otpVerify->otp_type);
                $save_request = DB::table('tbl_update_profile_request')
                                ->insert([
                                    'user_id' => $request->user->id,
                                    'field_value' => $field_value,
                                    'field_type' => $otpVerify->otp_type,
                                    'created_at' => Carbon::now()
                                ]);

                return response()->json([
                   'status' =>'success',
                   'message' => 'Profile updated request send successfully. Please wait until request is processed',
                    'StatusCode' => 200
                ]);
            }


        }

        public function otpVerifyByField($user_id, $field_value, $otp)
        {
            $query = DB::table('tbl_otp')
            ->where('user_id', $user_id)
            ->where('status',1)
            ->where('otp',$otp)
            ->where('field_value',$field_value)
            ->orderBy('id',"desc")
            ->first();
         
           return $query;
          
        }

        public function approve_update_request(Request $request)
        {
            $req_id = $request->req_id;
            $user_id = $request->user_id;
            $status = $request->status;
            $field_type = $request->field_type;
            if($request->user->role_id!=1)
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'Unauthorized access. Only admin can approve update request',
                    'StatusCode' => 202
                ]);
            }
            else
            {
                $update_request = DB::table('tbl_update_profile_request')
                                ->where('id', $req_id)
                                ->where('user_id', $user_id)
                                ->where('field_type', $field_type)
                                ->where('status', 1)
                                ->orderBy('id', "desc")
                                ->first();
                
                    if($update_request)
                    {
                        if($update_request->field_type==1)
                        {
                            $update_user_details = DB::table('users')
                            ->where('id', $user_id)
                            ->update(['mobile_no' => $update_request->field_value]); 
                        }
                        else
                        {
                            $update_user_details = DB::table('users')
                                            ->where('id', $user_id)
                                            ->update(['email' => $update_request->field_value]);
                        }
                        if($update_user_details)
                        {
                            DB::table('tbl_update_profile_request')
                                ->where('id', $req_id)
                                ->update(['status' => 2]);
                            return response()->json([
                               'status' =>'success',
                               'message' => 'Profile updated successfully',
                                'StatusCode' => 200
                            ]);
                        }
                        else
                        {
                            return response()->json([
                               'status' => 'error',
                               'message' => 'Profile Update Failed',
                               'StatusCode' => 500
                            ]);
                        }
            
                    }
                }
            }

            public function update_request_list(Request $request)
            {
                $user_id = $request->user->id;
                $status = $request->status;
                if($request->user->role_id!=3)
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'Unauthorized access. Only admin can view update request list',
                        'StatusCode' => 202
                    ]);
                }
                else
                {
                    $update_requests = DB::table('tbl_update_profile_request as a')
                    ->join('users as b', 'a.user_id', '=', 'b.id')
                    ->where('a.status', 1)
                    ->orderBy('a.id', 'desc')
                    ->select('a.*', 'b.name', 'b.email') // Select columns from both tables
                    ->get();
                
                    if($update_requests)
                    {
                        return response()->json([
                           'status' =>'success',
                           'message' => 'Update request list',
                            'StatusCode' => 200,
                            'data' => $update_requests
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'No update request found',
                            'StatusCode' => 404
                        ]);
                    }
                }
            }
         
            public function user_profile(Request $request)
            {
                $user_id = $request->user->id;
                $user_details = User::where('id', $user_id)
                    ->first();
                $role_details = DB::table('roles')
                ->where('id', $request->user->role_id)
                ->where('status',1)
                ->first();
                if($user_details)
                {
                    return response()->json([
                       'status' =>'success',
                       'message' => 'User profile',
                        'data' => $user_details,
                        'role' => $role_details->title,
                    ], 200);
                }
                else
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'User not found'
                    ], 401);
                }
            }

            public function user_list(Request $request)
            {
                
                if($request->user->role_id != 1)
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'Unauthorized access. Only admin can view user list',
                        'StatusCode' => 202
                    ]);
                }
                $users = User::where('status', '!=', 3)
                ->where('role_id', '!=', 1)
                ->with('role')  // Eager load the role relationship
                ->orderBy('id', 'desc');
                if ($request->has('user_id')) {
                    $users->where('id', $request->user_id);
                }
                if ($request->has('role_id')) {
                    $users->where('role_id', $request->role_id);
                }
                
                $user_list = $users->get();

                if(count($user_list)>0)
                {
                    return response()->json([
                       'status' =>'success',
                       'message' => 'User list',
                        'data' => $user_list
                    ], 200);
                }
                else
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'No user found'
                    ], 401);
                }
            }

            public function user_update_status(Request $request)
            {
                if($request->user->role_id != 1)
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'Unauthorized access. Only admin can update user status',
                        'StatusCode' => 202
                    ]);
                }
                $request->validate([
                    'user_id' =>'required',
                   'status' =>'required'  // 0 for inactive, 1 for active
                ]);
                if($request->status>3)
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'Invalid status'
                    ], 400);
                }
                $status = $request->status;
                switch ($status)
                {
                    
                    case 1:
                        $message = 'User activated successfully';
                        break;
                    case 2:
                        $message = 'User deactivated successfully';
                        break;
                    case 3:
                        $message = 'User Deleted successfully';
                        break;
                    default:
                        return response()->json([
                           'status' => 'error',
                           'message' => 'Invalid status'
                        ], 400);
                }
                $user_id = $request->user_id;
                $users = User::find($user_id);
                if(!$users)
                {
                    return response()->json([
                       'status' => 'error',
                       'message' => 'User not found'
                    ], 401);
                }
                $users->status = $status;
                $users->save();
                return response()->json([
                   'status' =>'success',
                   'message' => $message,
                    'StatusCode' => 200
                ], 200);
            }
            
        public function route_agent_list(Request $request)
        {
            $user_id = $request->user->id;
            if($request->user->role_id != 4)
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'Unauthorized access.',
                    'StatusCode' => 202
                ]);
            }
            
            $get_user_route = Loan::where('user_id', $user_id)->orderBy('id', 'desc')->first();
            $route_agents = DB::table('assignroutes as a')->leftJoin("users as b","a.user_id","b.id")->select('b.*')->where('a.route_id', $get_user_route->route_id)->where('b.status',1)->where('role_id',3)->get();
            
            if(count($route_agents)>0)
            {
                return response()->json([
                   'status' =>'success',
                   'message' => 'Route agent list',
                    'data' => $route_agents
                ], 200);
            }
            else
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'No route agent found'
                ], 401);
            }
        }

        // public function UpdateUserProfile()
         
        
        
}
