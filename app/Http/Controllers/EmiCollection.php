<?php

namespace App\Http\Controllers;
use App\Models\Emi_collection;
use App\Models\Loan;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class EmiCollection extends Controller
{
    //
    public function emi_collection(Request $request)
    {
        if($request->user->role_id != 4)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized Access.You are not allowed to update your mobile or email address.',
                'StatusCode' => 403
            ]);
        }
        $request->validate([
            'loan_number' => 'required',
            'emi_amount' => 'required',
            'agent_id' => 'required',
            'payment_mode' => 'required'
        ]);

        if($request->payment_mode != 1)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Please enter reference no'
            ], 401);
        }
        $loan_number = $request->loan_number;
        $emi_amount = $request->emi_amount;
        $agent_id = $request->agent_id;
        $payment_mode = $request->payment_mode;
        $reference_no = $request->reference_no;

        $loan_details = Loan::where('loan_number', $loan_number)->first();
        if(!$loan_details)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Loan not found with given loan number',
                'StatusCode' => 404
            ]);
        }
        $user  = User::where('id', $request->user->id)->where('status',1)->first();
        $emi_collection = new Emi_collection();
        $emi_collection->loan_id = $loan_details->id;
        $emi_collection->agent_id = $agent_id;
        $emi_collection->emi_amount = $emi_amount;
        $emi_collection->payment_mode = $payment_mode;
        $emi_collection->reference_no = $reference_no;
        if($emi_collection->save())
        {
        $token = $this->createJwtToken($user, $emi_collection->id);
        return response()->json([
               'status' =>'success',
               'message' => 'EMI Collection request created successfully',
                'token' => $token  
        ], 201);
        }
        else
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Failed to create EMI Collection request',
                'data' => $request->all()
            ], 401);
        }

        
        // $emi_collection = Emi_collection::where('loan_id',$loan_id)->where('emi_id',$emi_id)->first();
    }

    public function borrower_loan(Request $request)
    {
        if($request->user->role_id!=4)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Unauthorized access. Only borrowers can view loan list'
            ], 201);
        }
        $user_id = $request->user->id;
        $loan_number = $request->loan_number;
        $loan_status = $request->loan_status;
        $loan_id = $request->loan_id;
        $loans_details = Loan::where('user_id', $user_id)
                                ->where('status',1);
        if($loan_number)
        {
            $loans_details->where('loan_number', $loan_number);
        } 
        if($loan_status)
        {
            $loans_details->where('loan_status', $loan_status);
        } 
        $loan_list = $loans_details->get();                       
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

    private function createJwtToken($user, $emi_id)
    {
        $key = env('JWT_SECRET');  // Secret key
        $payload = [
            'emi_id' => $emi_id, // Issuer of the token
            'sub' => $user->id,           // Subject of the token (user ID)
            'iat' => time(),              // Issued at time
            'exp' => time() + 60*60       // Expiration time (1 hour)
        ];

        // Encode the token
        return JWT::encode($payload, $key, 'HS256');
    }

    public function emi_details(Request $request)
    {
        if($request->user->role_id!=4)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Unauthorized access.'
            ], 404);
        }

        $request->validate([
            'emi_token' => 'required'
        ]);

        $emi_token = $request->emi_token;
        $decoded = JWT::decode($emi_token, new Key(env('JWT_SECRET'), 'HS256'));
        $emi_id = $decoded->emi_id;
        $emi_details = Emi_collection::where('id', $emi_id)->first();
        if(!$emi_details)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'EMI not found'
            ], 404);
        }
        else
        {
            return response()->json([
               'status' =>'success',
               'message' => 'EMI details',
                'data' => $emi_details
            ], 202);
        }
        
    }

    public function emi_pay(Request $request)
    {
        if($request->user->role_id!=3)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'Unauthorized access.'
            ], 404);
        }

        $request->validate([
            'emi_token' =>'required'
        ]);
        $user_id = $request->user->id;
        $emi_token = $request->emi_token;

        $decoded = JWT::decode($emi_token, new Key(env('JWT_SECRET'), 'HS256'));
        $emi_id = $decoded->emi_id;
        $emi_details = Emi_collection::where('id', $emi_id)->where('agent_id', $user_id)->orderBy('id','desc')->first();
        
            
        if(!$emi_details)
        {
            return response()->json([
               'status' => 'error',
               'message' => 'EMI not found'
            ], 404);
        }
        $emi_update = Emi_collection::find($emi_details->id);
        $emi_update->emi_status = 2;
        if($emi_update->save())
        {
            $loan_details = Loan::find($emi_details->loan_id);
            $pending_amount = (str_replace(',','',$loan_details->pending_amount) - str_replace(',','',$emi_details->emi_amount));
            $loan_details->pending_amount = $pending_amount;
            $loan_details->save();

            return response()->json([
               'status' =>'success',
               'message' => 'EMI paid successfully'
            ], 202);
        }
    }
}
