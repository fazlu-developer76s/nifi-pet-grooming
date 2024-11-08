<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use App\Models\Loan_request;
use Illuminate\Http\Request;
use DB;

class KycController  extends Controller
{
    //
    public function user_kyc_request(Request $request)
    {
        
        $request->validate([
            'loan_request_id' => 'required',
            'aadhar_no' => 'required|digits:12|numeric|regex:/^[2-9]{1}[0-9]{11}$/',
            'pan_no' => 'required|size:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
        ]);
        $loan_request_id = $request->loan_request_id;
        $aadhar_no = $request->aadhar_no;
        $pan_no = $request->pan_no;
        if ($request->user->role_id != 3) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to kyc process.', 'data' => $request->all()], 401);
        }
        $loan_request = Loan_request::find($loan_request_id);
        
        if (!$loan_request) {
            return response()->json(['status' => 'error', 'message' => 'Loan request detail not found.', 'data' => $request->all()], 401);
        }
        if($loan_request->loan_status == 6)
        {
            return response()->json(['status' => 'error', 'message' => 'Loan request is not qualified from team.', 'data' => $request->all()], 401);
        }
        $kyc = new Kyc;
        $kyc_status = Kyc::where('loan_request_id', $loan_request_id)->orderBy('id', 'desc')->first();
        if ($kyc_status) {
            $kyc = Kyc::find($kyc_status->id); // Retrieve the existing KYC by ID
        } else {
            $kyc = new Kyc();
        }

        $kyc->loan_request_id = $loan_request_id;
        $kyc->customer_name = $request->customer_name;
        $kyc->son_of = $request->son_of;
        $kyc->type_of_work = $request->type_of_work;
        $kyc->shop_address = $request->shop_address;
        $kyc->shop_type = $request->shop_type;
        $kyc->home_address = $request->home_address;
        $kyc->home_type = $request->home_type;
        $kyc->mobile_no = $request->mobile_no;
        $kyc->sms_no = $request->sms_no;
        $kyc->reference_1_name = $request->reference_1_name;
        $kyc->reference_1_mobile = $request->reference_1_mobile;
        $kyc->reference_1_relation = $request->reference_1_relation;
        $kyc->reference_2_name = $request->reference_2_name;
        $kyc->reference_2_mobile = $request->reference_2_mobile;
        $kyc->reference_2_relation = $request->reference_2_relation;
        $kyc->loan_amount = $request->loan_amount;
        $kyc->processing_fees = $request->processing_fees;
        $kyc->emi = $request->emi;
        $kyc->agent_id = $request->user->id;
        $kyc->aadhar_no = $aadhar_no;
        $kyc->pan_no = $pan_no;
        $kyc->remark = $request->remark;
        $kyc->kyc_status = 2;

        if ($request->hasFile('aadhar_docs')) {
            // Store the file in the 'uploads' directory in storage/app/public/uploads
             $request->file('aadhar_docs')->store('kyc_docs', 'public');
            $aadhar_docs = $request->file('file')->getClientOriginalName();
            $kyc->aadhar_docs = $aadhar_docs;
        }
        if ($request->hasFile('pan_docs')) {
            // Store the file in the 'uploads' directory in storage/app/public/uploads
             $request->file('pan_docs')->store('kyc_docs', 'public');
            $pan_docs = $request->file('file')->getClientOriginalName();
            $kyc->pan_docs = $pan_docs;
        }
        

        if ($kyc->save()) {
            $loan_request->loan_status = 4;
            $loan_request->save();
            if ($kyc_status) {
                return response()->json(['status' => 'Success', 'message' => 'KYC request updated successfully.', 'data' => $request->all()], 200);
            } else {
                return response()->json(['status' => 'Success', 'message' => 'KYC request submitted successfully.', 'data' => $request->all()], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'KYC request failed to submit.', 'data' => $request->all()], 401);
        }
    }

    public function kyc_request_list(Request $request)
    {
        if ($request->user->role_id != 3) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to view kyc list.', 'data' => $request->all()], 401);
        }
        $kyc_list = Kyc::where('status', '<', 3);
        if ($request->user_id) {
            $kyc_list->where('user_id', $request->user_id);
        }
        if ($request->loan_request_id) {
            $kyc_list->where('loan_request_id', $request->loan_request_id);
        }
        $kyc_list->orderBy('id', 'desc');
        $kyc_data = $kyc_list->get();
        
      
        $user_id = $request->user->id;
        $get_kyc_data = DB::table('kyc_leads as a')
            ->join('assignroutes as b', 'a.route_id', '=', 'b.route_id')
            ->join('loan_requests as c','a.loan_request_id', '=', 'c.id')
            ->select('b.id as assign_id', 'a.*','c.name as loan_customer_name','c.mobile as loan_customer_mobile','c.email as loan_customer_email','c.loan_amount as loan_customer_amount')
            ->where('a.kyc_status','!=', 3)
            ->where('a.kyc_status','!=', 4)
            ->where('c.loan_status','!=', 6)
            ->where('b.user_id', $user_id);
            if ($request->loan_request_id) {
                $get_kyc_data->where('a.loan_request_id', $request->loan_request_id);
            }
           $kyc_data =  $get_kyc_data->get();

        if ($kyc_data) {
            return response()->json(['status' => 'Success', 'message' => 'KYC list.', 'data' => $kyc_data], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No KYC found for this user.', 'data' => $request->all()], 401);
        }
    }

    public function kyc_approval(Request $request)
    {
        if ($request->user->role_id != 1) {
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to approve KYC.', 'data' => $request->all()], 401);
        }
        $request->validate([
            'kyc_id' => 'required',
            'kyc_status' => 'required'
        ]);
        $kyc_id = $request->kyc_id;
        $kyc_status = $request->kyc_status;
        if ($kyc_status  > 5) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid status'
            ], 400);
        }
        $kyc = Kyc::find($kyc_id);
        if (!$kyc) {
            return response()->json(['status' => 'error', 'message' => 'KYC detail not found.', 'data' => $request->all()], 401);
        }
        $kyc->kyc_status = $kyc_status;
        if ($kyc->save()) {
            switch ($kyc_status) {
                case 1:
                    $message = "kyc status is pending updated successfully";
                    break;
                case 2:
                    $message = "kyc status is In Progress updated successfully";
                    break;
                case 3:
                    $message = "kyc status is Completed updated successfully";
                    break;
                case 4:
                    $message = "kyc status is Approved updated successfully";
                    break;
                case 5:
                    $message = "kyc status is Rejected updated successfully";
                    break;
            }
            return response()->json([
                'status' => 'success',
                'message' => $message
            ], 200);
        }
    }

    public function kyc_pending_list(Request $request)
    {

        $user_id = $request->user->id;
        $get_kyc_data = DB::table('assignroutes')
            ->leftJoin('kyc_leads', 'assignroutes.route_id', '=', 'kyc_leads.route_id')
            ->select('assignroutes.id as assign_id', 'kyc_leads.*')
            ->where('assignroutes.user_id', $user_id)
            ->get();
            if($get_kyc_data){
                return response()->json(['status' => 'Success', 'message' => 'KYC list.', 'data' => $get_kyc_data], 200);
            }else{
              return response()->json(['status' => 'error', 'message' => 'No data Found.', 'data' => $request->all()], 401);
            }
    }

    public function kyc_submit(Request $request){

        return response()->json($_POST);
    }

    public function kycDocs(Request $request){
        $loan_request_id = $request->loan_request_id;
        $request->validate([
            'loan_request_id' => 'required',
            'aadhar_docs' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'pan_docs' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'elec_bill' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'photo' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'business_pic' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'gurn_docs' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'side_verify' =>'nullable|mimes:jpg,png,pdf|max:2048',
            'rc_vehicle' =>'nullable|mimes:jpg,png,pdf|max:2048'
        ]);
        $kyc = kyc::where('loan_request_id', $loan_request_id)->first();
        if(!$kyc)
        {
            return response()->json(['status' => 'error', 'message' => 'No KYC found for this loan request.'], 404);
        }
        
        if ($request->hasFile('aadhar_docs')) {
            $originalName = $request->file('aadhar_docs')->getClientOriginalName();
            $aadhar_docs = time() . '_' . $originalName;
            $request->file('aadhar_docs')->storeAs('kyc_docs', $aadhar_docs, 'public');
            $kyc->aadhar_docs = $aadhar_docs;
        }

        if ($request->hasFile('pan_docs')) {
            $originalName = $request->file('pan_docs')->getClientOriginalName();
            $pan_docs = time() . '_' . $originalName;
            $request->file('pan_docs')->storeAs('kyc_docs', $pan_docs, 'public');
            $kyc->pan_docs = $pan_docs;
        }

        if ($request->hasFile('elec_bill')) {
            $originalName = $request->file('elec_bill')->getClientOriginalName();
            $elec_bill = time() . '_' . $originalName;
            $request->file('elec_bill')->storeAs('kyc_docs', $elec_bill, 'public');
            $kyc->elec_bill = $elec_bill;
        }

        if ($request->hasFile('photo')) {
            $originalName = $request->file('photo')->getClientOriginalName();
            $photo = time() . '_' . $originalName;
            $request->file('photo')->storeAs('kyc_docs', $photo, 'public');
            $kyc->photo = $photo;
        }

        if ($request->hasFile('business_pic')) {
            $originalName = $request->file('business_pic')->getClientOriginalName();
            $business_pic = time() . '_' . $originalName;
            $request->file('business_pic')->storeAs('kyc_docs', $business_pic, 'public');
            $kyc->business_pic = $business_pic;
        }

        if ($request->hasFile('gurn_docs')) {
            $originalName = $request->file('gurn_docs')->getClientOriginalName();
            $gurn_docs = time() . '_' . $originalName;
            $request->file('gurn_docs')->storeAs('kyc_docs', $gurn_docs, 'public');
            $kyc->gurn_docs = $gurn_docs;
        }

        if ($request->hasFile('side_verify')) {
            $originalName = $request->file('side_verify')->getClientOriginalName();
            $side_verify = time() . '_' . $originalName;
            $request->file('side_verify')->storeAs('kyc_docs', $side_verify, 'public');
            $kyc->side_verify = $side_verify;
        }

        if ($request->hasFile('rc_vehicle')) {
            $originalName = $request->file('rc_vehicle')->getClientOriginalName();
            $rc_vehicle = time() . '_' . $originalName;
            $request->file('rc_vehicle')->storeAs('kyc_docs', $rc_vehicle, 'public');
            $kyc->rc_vehicle = $rc_vehicle;
        }
        
        if($kyc)
        {
            $kyc->save();
            return response()->json(['status' => 'Success', 'message' => 'KYC documents updated successfully.'], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Failed to update KYC documents.'], 500);
        }
        
        

    }

}
