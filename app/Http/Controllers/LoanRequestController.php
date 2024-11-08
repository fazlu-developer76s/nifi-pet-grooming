<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan_request;
use App\Models\Kyc;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Middleware\JwtMiddleware;
use App\Models\User;
use App\Models\Loan;
use App\Helpers\Global_helper as GlobalHelper;
use App\Models\Providers;
use App\Models\Loan_disbursement;
use App\Models\Payment_mode;
use App\Models\Bank;
use DB;
use Carbon\Carbon;

class LoanRequestController extends Controller

{
    //

    public function create_loan_request(Request $request)
    {
        if ($request->bearerToken()) {

           try {
              $decoded = JWT::decode($request->bearerToken(), new Key(env('JWT_SECRET'), 'HS256'));
              $request->auth = $decoded;
              $request->user = User::find($decoded->sub);

              if(!$this->CheckToken($request->user->id,$request->bearerToken())) {
                return response()->json([
                    'status' => 'error',
                   'message' => 'Token is invalid or expired'
                  ],401);
              }
           }
           catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid or expired'
              ], 401);
        }
       }
        $request->validate([
            'mobile' => 'required',
            'loan_amount' => 'required',
            'email' => 'required',
            'name'  => 'required',
            'zip_code' => 'required|digits:6|numeric',
        ]);
        
        $checkZipCode = DB::table('routezips as a')->leftJoin('routes as b','b.id','=','a.route_id')->select('a.*')->where('b.status',1)->where('a.zip_code', trim($request->zip_code))->where('a.status', 1)->first();
        if(!$checkZipCode)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Not Available at your zip code'
            ], 400);
        }

        $loan_request = new Loan_request();
        $loan_request->name = $request->name;
        $loan_request->mobile = $request->mobile;
        $loan_request->email = $request->email;
        $loan_request->loan_amount = $request->loan_amount;
        $loan_request->reason_of_loan = $request->reason_of_loan;
        $loan_request->zip_code = $request->zip_code;
        
        if($request->user)
        {

            $loan_request->user_id = $request->user->id;
            $loan_request->referal_name = $request->user->name;
            $loan_request->referal_mobile = $request->user->mobile_no;
        }
        $token = $this->createJwtToken($request->all());
        $loan_request->token = $token;
        if($loan_request->save())
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Loan request created successfully'
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
               'message' => 'Failed to create loan request'
            ], 500);
        }
    }

    private function createJwtToken($lead_info)
    {
        $key = env('JWT_SECRET');  // Secret key
        $payload = [
            'iss' => "loan-request", // Issuer of the token
            'sub' => $lead_info,           // Subject of the token (user ID)
            'iat' => time(),              // Issued at time
            'exp' => time() + 60*60       // Expiration time (1 hour)
        ];

        // Encode the token
        return JWT::encode($payload, $key, 'HS256');
    }

    public function CheckToken($user_id,$token)
    {
        $checkToken = DB::table('tbl_token')
            ->where('user_id', $user_id)
            ->where('token', $token)
            ->where('status', 1)
            ->first();
        if($checkToken)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function loan_request_list(Request $request)
    {
       DB::enableQueryLog();  // Enable query log

        $loan_requests = DB::table('loan_requests as a')->leftJoin('kyc_leads as b','a.id','=','b.loan_request_id')->leftJoin('loans as c','b.id','=','c.kyc_id')->where('a.status',1);
        if($request->loan_status)
        {
            $loan_requests->where('a.loan_status',$request->loan_status);
        }
        if($request->name)
        {
            $loan_requests->where('a.name','like',"%$request->name%");
        }
        if($request->mobile)
        {
            $loan_requests->where('a.mobile','like',"%$request->mobile%");
        }
        if($request->email)
        {
            $loan_requests->where('a.email','like',"%$request->email%");
        }
        if($request->loan_amount)
        {
            $loan_requests->where('a.loan_amount','like',"%$request->loan_amount%");
        }
        if($request->user->role_id != 1)
        {
            $loan_requests->where('a.user_id',$request->user->id);
        }
        
        $get_loan_list = $loan_requests->select('a.*','c.loan_status as loan_disbursement_status','b.kyc_status')->get();
        
        if($get_loan_list)
        {
            $loan_list_req = array();
            foreach($get_loan_list as $loan_list)
            {
                if($loan_list->loan_disbursement_status!=3 && $loan_list->kyc_status!=3)
                {
                $loan_list_req[] = $loan_list;
                }
            }
        return response()->json([
            'status' => 'success',
           'message' => 'Loan request list',
            'data' => $loan_list_req
        ], 200);
       }
       else
       {
         return response()->json([
            'status' => 'error',
           'message' => 'No loan request found'
        ], 404);
       }

    }


    public function create_loan(Request $request){

        $request->validate([
            'loan_request_id' =>'required',
            'amount' =>'required',
            'rate_of_interest' =>'required',
            'frequency' =>'required',
            'tenure' =>'required'
        ]);
        $check_kyc = $this->get_kyc_details($request->loan_request_id);
        if(!$check_kyc)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'KYC details not found'
            ], 401);
        }
        else
        {
            if($check_kyc->kyc_status != 4)
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'KYC verification pending'
                ], 401);
            }
        }
        $loan_request = Loan_request::find($request->loan_request_id);
        $getRoute = $this->getRoute($loan_request->zip_code);
        if(!$getRoute)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Invalid zip code'
            ], 400);
        }
        $loan_details = Loan::where('status',3)->orderBy('id', 'desc')->first();
        $checkLoanRequest =  Loan::where('loan_request_id',$request->loan_request_id)->orderBy('id', 'desc')->first();
        if($checkLoanRequest)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Loan request already processed'
            ], 401);
        }
        $loan_number = ($loan_details) ? $loan_details->loan_number + 1 : 110000000001;
        if($loan_request)
        {
             $loan = Loan::insert([
                'loan_request_id' => $request->loan_request_id,
                'route_id' => $getRoute->route_id,
                'amount' => $request->amount,
                'loan_number' => $loan_number,
                'rate_of_interest' => $request->rate_of_interest,
                'frequency' => $request->frequency,
                'tenure' => $request->tenure,
                'process_charge' => $request->process_charge,
                'file_charge' => $request->file_charge,
                'other_charges_1' => $request->other_charges_1,
                'other_charges_2' => $request->other_charges_2,
                'other_charges_3' => $request->other_charges_3,
                'other_charges_4' => $request->other_charges_4,
                'other_charges_5' => $request->other_charges_5,
                'created_at' => now()
             ]);
             if($loan)
             {
                return response()->json([
                   'status' =>'success',
                   'message' => 'Loan created successfully.Please wait untill admin disbrused the loan amount'
                ], 200);
             }
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Loan request not found'
            ], 401);
        }
    }

    public function loan_list(Request $request)
    {
        $loan_status = $request->loan_status;
        $loan_request_id = $request->loan_request_id;
        $loan_id  = $request->id;
        $loan_number = $request->loan_number;

        $loan_request= Loan::where('status',1);
        if($loan_status)
        {
            $loan_request->where('loan_status', $loan_status);
        }
        if($loan_request_id)
        {
            $loan_request->where('loan_request_id', $loan_request_id);
        }
        if($loan_id)
        {
            $loan_request->where('id', $loan_id);
        }
        if($loan_number)
        {
            $loan_request->where('loan_number', $loan_number);
        }

        $list = $loan_request->get();
        if($list)
        {
        return response()->json([
           'status' =>'success',
           'message' => 'Loan list',
            'data' => $list
        ], 200);
       }
       else
       {
         return response()->json([
            'status' => 'error',
           'message' => 'No loan found'
        ], 404);
       }
    }

    public function loan_approval(Request $request)
    {
        if($request->user->role_id!=1)
       {
        return response()->json([
            'status' => 'error',
           'message' => 'You Dont have permission to view loan request list'
        ], 401);
       }
        $request->validate([
            'loan_id' =>'required',
            'loan_status' =>'required',
            'loan_start_date' =>'required'
        ]);
        $loan_id = $request->loan_id;
        $loan_status = $request->loan_status;
        $loan_start_date = $request->loan_start_date;
        $loan = Loan::find($loan_id);
        $kyc_details = $this->get_kyc_details($loan->loan_request_id);
        if(!$kyc_details)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'KYC details not found for this loan'
            ], 401);
        }
        else
        {
            if($kyc_details->kyc_status != 4)
            {
                return response()->json([
                   'status' => 'error',
                   'message' => 'KYC is not approved for this loan'
                ], 401);
            }
        }
        if($loan)
        {
            $loan_request = Loan_request::find($loan->loan_request_id);
            if($loan_status == 3)
            {
            $disbrused_amount = $loan->amount - ($loan->file_charge + $loan->other_charges_1 + $loan->other_charges_2 + $loan->other_charges_3 + $loan->other_charges_4 + $loan->other_charges_5);

            $emiData = GlobalHelper::calculateEMI($loan->amount, $loan->rate_of_interest, $loan->tenure);
            $emi_amount = "";
            switch($loan->frequency)
            {
                case 1 : $emi_amount = $emiData['daily_emi'];
                break;
                case 2 : $emi_amount = $emiData['weekly_emi'];
                break;
                case 3 : $emi_amount = $emiData['monthly_emi'];
                break;
            }
            // $users_details = User::where('aadhar_no', $kyc_details->aadhar_no)->where('status',1)->first();

            $users_details = User::where(function($query) use ($kyc_details, $loan_request) {
                $query->where('aadhar_no', $kyc_details->aadhar_no)
                      ->orWhere('mobile_no', $loan_request->mobile)
                      ->orWhere('email', $loan_request->email);
            })
            ->where('status', 1)
            ->first();

            $loan->disbrused_amount = $disbrused_amount;
            $loan->pending_amount   = number_format((floatval(str_replace(',','',$emi_amount)) * floatval($loan->tenure)),2);
            $loan->emi_amount   = $emi_amount;
            $loan->loan_start_date  = $loan_start_date;
            $loan->loan_status = $loan_status;
            $loan->save();

            if($users_details)
            {
                $user_record = User::find($users_details->id);
            }
            else
            {
                $user_record = new User();
            }
            $user_record->aadhar_no = (@$users_details->aadhar_no) ? $users_details->aadhar_no :  $kyc_details->aadhar_no;
            $user_record->mobile_no = (@$users_details) ?  $users_details->mobile_no : $loan_request->mobile;
            $user_record->name = ($loan_request->name) ? $loan_request->name : @$users_details->name;
            $user_record->email = (@$users_details->email) ? $users_details->email : $loan_request->email;
            $user_record->role_id = 4;
            $user_record->save();
            $insertedId = $user_record->id;
            $loan->user_id = $insertedId;
            $loan->route_id = $routes->route_id;
            }


            $loan_request->status = 5;
            $loan_request->save();
            $message = "";
            switch($loan_status)
            {
                case 1 : $message = "Loan status is pending.";
                break;
                case 2 : $message =  "Loan status is Approvad but not disbursed.";
                break;
                case 3 : $message =  "Congratulations. you have successfully disbrused the loan.";
                break;
                case 4 : $message =  "Loan status is rejected.";
                break;
            }
            return response()->json([
               'status' =>'success',
               'message' => $message
            ], 200);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Loan not found'
            ], 200);
        }
    }

    public function get_kyc_details($loan_request_id)
    {
        $kyc_details = Kyc::where('loan_request_id',$loan_request_id)
                           ->where('status',1)
                           ->orderBy('id', 'DESC')
                           ->first();
        if($kyc_details)
        {
            return $kyc_details;
        }

            return false;
    }

    public function getRoute($zipcode)
    {
        $getZipcode = DB::table('routezips')->where('zip_code',$zipcode)->where('status',1)->first();
        if($getZipcode)
        {
            return $getZipcode;
        }
        return false;
    }

    public function my_loan(Request $request)
    {
        $user_id = $request->user->id;
        $loan_status = $request->loan_status;
        $loan_request = Loan::where('user_id', $user_id)
                        ->where('loan_status',3)
                        ->orWhere('loan_status', 5);
        if($loan_status)
        {
            $loan_request->where('loan_status', $loan_status);
        }                
               $loan_list   = $loan_request->get();
        if($loan_list)
        {
            return response()->json([
               'status' =>'success',
               'message' => 'Loan list',
                'data' => $loan_list
            ], 200);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'No loan found'
            ], 404);
        }
    }

    public function loan_report(Request $request)
    {
        
        $user_id = $request->user->id;
        if($request->user->role_id != 1)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'You Dont have permission to view loan report'
            ], 401);
        }
        
        $loan_status = $request->loan_status;
        $from_date = $request->from_date;
        $to_date  = $request->to_date;
        $user_id  = $request->user_id;
        $loan_request = Loan::where('status', 1);
        if($loan_status)
        {
            $loan_request->where('loan_status', $loan_status);
        }  
        if($to_date)
        {
            $loan_request->where('created_at', ' >= ', $to_date);
        }  
        if($to_date)
        {
            $loan_request->where('created_at', ' <= ' ,  $to_date);
        }  
            
               $loan_list   = $loan_request->get();
        if($loan_list)
        {
            return response()->json([
               'status' =>'success',
               'message' => 'Loan list',
                'data' => $loan_list
            ], 200);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'No loan found'
            ], 404);
        }
    }

    public function service_list(Request $request)
    {
        
        $user_id = $request->user->id;
        // if($request->user->role_id != 1)
        // {
        //     return response()->json([
        //        'status' => 'error',
        //        'message' => 'You Dont have permission to view loan report'
        //     ], 401);
        // }
        
        $route = $request->service_no;
        $service_name = $request->service_name;
        $service = Providers::where('status', 1);
        
        if($route)
        {
            $service->where('route', $route);
        }  
        if($service_name)
        {
            $service->where('title', 'like', "%$service_name%");
        }  
            
               $service_list   = $service->get();
        if($service_list)
        {
            return response()->json([
               'status' =>'success',
               'message' => 'Services list',
                'data' => $service_list
            ], 200);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'No Services found'
            ], 404);
        }
    }

    public function ready_for_disbursement_loan(Request $request)
    {
        if($request->user->role_id != 3)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'You Dont have permission to view loan report'
            ], 401);
        }
        $user_id = $request->user->id;
        $loan_list = DB::table('loans as a')->leftJoin('assignroutes as b','a.route_id','=','b.route_id')->where('a.loan_status',2)->where('b.user_id', $user_id)->select('a.*')->get();
        if($loan_list)
        {
            return response()->json([
               'status' =>'success',
               'message' => 'Ready for disbursement Loan list',
                'data' => $loan_list
            ], 200);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'No ready for disbursement loan found'
            ], 404);
        }

    }

    public function loan_disbursement(Request $request)
    {
        if($request->user->role_id != 3)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'You Dont have permission to disbursement Loan List'
            ], 401);
        }
        $request->validate([
            'loan_id' =>'required',
            'disbursement_amount' =>'required',
            'disbursement_mode' =>'required',
            'disbursement_date' =>'required',
            'loan_number' =>'required',
            'remark'     =>'required',
        ]);
        $user_id = $request->user->id;
        $loan_id = $request->loan_id;
        $disbursement_amount = $request->disbursement_amount;
        $disbursement_mode = $request->disbursement_mode;
        $disbursement_date = $request->disbursement_date;
        $loan_number = $request->loan_number;
        $remark = $request->remark;
        if($disbursement_mode!=1)
        {
            if($request->reference_no=='')
            {
            return response()->json([
               'status' => 'error',
               'message' => 'Reference no. not found'
            ], 401);
            }
        }
        
        $loan_disbursement = Loan_disbursement::where('loan_id',$loan_id)->first();
        $check_loan = Loan::where('id',$loan_id)->first();
        $users_details = User::find($check_loan->user_id);
        if($loan_disbursement)
        {
            $loan_details = Loan_disbursement::find($loan_disbursement->id);
        }
        else
        {
            $loan_details = new Loan_disbursement();
        }
        $loan_details->loan_id = $loan_id;
        $loan_details->disbursement_amount = $disbursement_amount;
        $loan_details->disbursement_mode = $disbursement_mode;
        $loan_details->disbursement_date = $disbursement_date;
        $loan_details->loan_number = $loan_number;
        if($disbursement_mode!=1)
        {
        $loan_details->reference_no = $request->reference_no;
        }
        $loan_details->remark = $remark;
        if($loan_details->save())
        {
            $module_type = 3;
            $otp_type = 1;
           if(GlobalHelper::GenerateOTP($users_details, $module_type, $otp_type))
           {
               return response()->json([
                  'status' => 'success',
                  'message' => 'OTP sent to your registered mobile',
                  'data' => $request->all()
               ],200);
           }
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Failed to loan disbursement'
            ], 500);
        }
    }

    public function borrower_image(Request $request)
    {
        if($request->user->role_id != 3)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'You Dont have permission to disbursement Loan List'
            ], 401);
        }
        
        $request->validate([
            'loan_id' =>'required',
            'image' =>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $loan_id = $request->loan_id;
        $loan_disbursement = Loan_disbursement::where('loan_id',$loan_id)->first();
        if($loan_disbursement)
        {
            $loan_details = Loan_disbursement::find($loan_disbursement->id);
        }
        else
        {
            $loan_details = new Loan_disbursement();
        }


        if ($request->hasFile('image')) {
            // Get the original file name
            $originalName = $request->file('image')->getClientOriginalName();
        
            // Create a unique name for storing the file in the folder
            $uniqueName = time() . '_' . $originalName;
        
            // Store the file with the unique name in the 'borrower' folder under 'public'
            $request->file('image')->storeAs('borrower', $uniqueName, 'public');
        
            // Save the original name in the database
            $loan_details->image = $uniqueName;
        }
        if($loan_details->save())
        {
            return response()->json([
               'status' =>'success',
               'message' => 'Image uploaded successfully'
            ], 200);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Failed to upload image'
            ],401);
       } 
   }

   public function disbursement_otp(Request $request)
   {

    if($request->user->role_id != 3)
    {
        return response()->json([
           'status' => 'error',
           'message' => 'You Dont have permission to disbursement Loan List'
        ], 401);
    }
    
    $request->validate([
        'loan_id' =>'required',
        'otp' => 'required|numeric|digits:4',
    ]);
    $loan_id = $request->loan_id;
    $otp = $request->otp;
    $loan_disbursement = Loan_disbursement::where('loan_id',$loan_id)->first();
    $check_loan = Loan::where('id',$loan_id)->first();
    $otp_type = 1;
    $module_type = 3;
    $otp_details = $this->otpVerify($check_loan->user_id, $otp, $otp_type, $module_type);
    
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
                   
                    if($loan_disbursement)
                    {
                        $loan_details = Loan_disbursement::find($loan_disbursement->id);
                    }
                    else
                    {
                        $loan_details = new Loan_disbursement();
                    }
                    if($loan_details->disbursement_amount=='')
                    {
                        return response()->json([
                           'status' => 'error',
                           'message' => 'Disbursement amount not found'
                        ], 401);
                    }
                    if($loan_details->disbursement_mode=='')
                    {
                        return response()->json([
                           'status' => 'error',
                           'message' => 'Disbursement mode not found'
                        ], 401);
                    }
                    if($loan_details->image=='')
                    {
                        return response()->json([
                           'status' => 'error',
                           'message' => 'Borrower image not found'
                        ], 401);
                    }
                    if($loan_details->disbursement_amount=='')
                    {
                        return response()->json([
                           'status' => 'error',
                           'message' => 'Disbursement amount not found'
                        ], 401);
                    }
                    if($loan_details->loan_number=='')
                    {
                        return response()->json([
                           'status' => 'error',
                           'message' => 'Loan Number not found'
                        ], 401);
                    }
                    
                    $loan_details->disbrused_status = 2;
                    DB::table('loans')
                                ->where('id', $check_loan->id)
                                ->update(['loan_status' => 3]);

                    if($loan_details->save())
                    {
                        return response()->json([
                           'status' =>'success',
                           'message' => 'Loan disbursed successfully',
                            'data' => $request->all()
                        ], 200);
                    }
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

        public function payment_modes(Request $request)
        {
            $payment_modes = Payment_mode::where('status',1)->get();
            if($payment_modes)
            {
            return response()->json([
               'status' =>'success',
               'message' => 'Payment modes fetched successfully',
                'data' => $payment_modes
            ], 200);
           }
           else
           {
            return response()->json([
               'status' => 'error',
               'message' => 'No payment modes found'
            ], 404);
           }
        }

        public function bank_details(Request $request)
        {
            $bank_details = Bank::all();
            if($bank_details)
            {
            return response()->json([
               'status' =>'success',
               'message' => 'Bank Details fetched successfully',
                'data' => $bank_details
            ], 200);
           }
           else
           {
            return response()->json([
               'status' => 'error',
               'message' => 'No Bank Details found'
            ], 404);
           }
        }
}
