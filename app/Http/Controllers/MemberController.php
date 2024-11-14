<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Roles;
use App\Models\Member;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    public function index()
    {

        $title = "Member List";
        $allmember = DB::table('users')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->where('users.role_id', 2)->where('users.status', '!=', 3)->select('users.*', 'roles.title')->get();
        return view('member.index', compact('title', 'allmember'));
    }

    public function member_kyc(Request $request)
    {
        $title = "KYC Member";

        // Base query
        $query = DB::table('kyc_processes')
            ->join('users', 'kyc_processes.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.status', 1)
            ->where('roles.status', 1)
            ->select(
                'users.name as user_name',
                'users.email as email',
                'users.mobile_no as mobile_no',
                'users.aadhar_no as aadhar_no',
                'roles.title as role_title',
                'kyc_processes.*'
            );

        // Add status filter if provided
        if ($request->filled('kyc_status')) {
            $query->where('kyc_processes.kyc_status', $request->input('kyc_status'));
        }
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->where(function ($query) use ($request) {
                $query->where('kyc_processes.created_at', '>=', $request->input('from_date'))
                      ->where('kyc_processes.created_at', '<=', $request->input('to_date'));
            });
        }

        $allkyc = $query->get();

        return view('member.kyc_member', compact('title', 'allkyc'));
    }


    public function view_member_kyc($id)
    {

        $title = "KYC Member";
        $member = DB::table('kyc_processes')
            ->join('users', 'kyc_processes.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.status', 1)
            ->where('roles.status', 1)
            ->where('kyc_processes.id', $id)
            ->select('users.name as user_name', 'users.email as email', 'users.mobile_no as mobile_no', 'users.aadhar_no as aadhar_no', 'roles.title as role_title', 'kyc_processes.*')
            ->first();
        return view('member.view_kyc_member', compact('title', 'member'));
    }

    public function create(Request $request)
    {

        if ($request->method() == 'POST') {
            $request->validate([
                'name' => 'required|string|max:255',
                'role_id' => 'required',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'mobile_no' => [
                    'required',
                    'regex:/^[6-9]\d{9}$/'
                ],
                'aadhar_no' => [
                    'required',
                    'regex:/^\d{12}$/'
                ],
                'status' => 'required',
                'password' => [
                    'required',
                    'string',

                ],
            ]);
            $check_data =  $this->check_exist_data($request, null);
            if (!empty($check_data)) {
                if ($check_data->email == $request->email) {
                    $message = "Email Address";
                }
                if ($check_data->mobile_no == $request->mobile_no) {
                    $message = "Mobile No.";
                }
                if ($check_data->aadhar_no == $request->aadhar_no) {
                    $message = "Aadhar No.";
                }
                if ($check_data) {
                    return redirect()->route('member.create')->with('error', '' . $message . ' Already Exists');
                }
            }
            $member = new Member();
            $member->name = $request->name;
            $member->role_id = $request->role_id;
            $member->email = $request->email;
            $member->mobile_no = $request->mobile_no;
            $member->employe_type = $request->employe_type;
            $member->aadhar_no = $request->aadhar_no;
            $member->status = $request->status;
            $member->password = Hash::make($request->password);
            $member->save();
            $insert_id = $member->id;
            return redirect()->route('member')->with('success', 'Member Added Successfully');
        }

        $title = "Add Member";
        $get_role = Roles::where('status', 1)->where('id', 2)->get();
        return view('member.create', compact('title', 'get_role'));
    }

    public function edit($id)
    {
        $title = "Edit Member";
        $get_member = Member::where('status', '!=', 3)->where('role_id', '!=', 1)->where('id', $id)->first();
        $get_role = Roles::where('status', 1)->where('id', 2)->get();
        return view('member.create', compact('title', 'get_member', 'get_role',));
    }

    public function view($id)
    {
        $title = "Edit Member";
        $running_loan = DB::table('users')->leftJoin('loans', 'users.id', '=', 'loans.user_id')->select('users.name as username', 'users.aadhar_no as user_aadhar_no', 'users.mobile_no as user_mobile_no', 'loans.*')->where('users.id', $id)->where('users.status', 1)->where('loans.status', 1)->where('loans.loan_status', 3)->get();
        $close_loan = DB::table('users')->leftJoin('loans', 'users.id', '=', 'loans.user_id')->select('users.name as username', 'users.aadhar_no as user_aadhar_no', 'users.mobile_no as user_mobile_no', 'loans.*')->where('users.id', $id)->where('users.status', 1)->where('loans.status', 1)->where('loans.loan_status', 5)->get();
        $all_loan = DB::table('users')->leftJoin('loans', 'users.id', '=', 'loans.user_id')->select('users.name as username', 'users.aadhar_no as user_aadhar_no', 'users.mobile_no as user_mobile_no', 'loans.*')->where('users.id', $id)->where('users.status', 1)->where('loans.status', 1)->get();
        return view('member.view', compact('title', 'running_loan', 'close_loan', 'all_loan'));
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/'
            ],
            'aadhar_no' => [
                'required',
                'regex:/^\d{12}$/'
            ],
            'status' => 'required',
        ]);

        // Check if the email, mobile number, or Aadhar number already exists
        $check_data = $this->check_exist_data($request, $request->hidden_id);

        // Prepare the error message if the data exists
        if ($check_data) {
            $message = '';

            if ($check_data->email == $request->email) {
                $message .= "Email Address ";
            }
            if ($check_data->mobile_no == $request->mobile_no) {
                $message .= "Mobile No. ";
            }
            if ($check_data->aadhar_no == $request->aadhar_no) {
                $message .= "Aadhar No. ";
            }

            // Redirect back with an error message if any data exists
            if ($message) {
                return redirect()->route('member.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        // Retrieve the member to update
        $member = Member::findOrFail($request->hidden_id);
        $member->name = $request->name;
        $member->role_id = $request->role_id;
        $member->email = $request->email;
        $member->mobile_no = $request->mobile_no;
        $member->employe_type = $request->employe_type;
        $member->aadhar_no = $request->aadhar_no;
        $member->status = $request->status;
        $member->save(); // Use save() to persist the changes

        // Redirect to the member list with a success message
        return redirect()->route('member')->with('success', 'Member Updated Successfully');
    }


    public function destroy($id)
    {

        $member = Member::findOrFail($id);
        $member->status = 3;
        $member->update();
        return redirect()->route('member')->with('success', 'Member deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Member::where('status', '!=', 3);

        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_member = $query->where(function ($q) use ($request) {
            $q->where('email', $request->email)
                ->orWhere('mobile_no', $request->mobile_no)
                ->orWhere('aadhar_no', $request->aadhar_no);
        })->first();

        return $check_member;
    }

    public function check_otp(Request $request)
    {
        $otp = $request->otp;
        $user_id = Auth::user()->id;
        $get_otp = DB::table('tbl_otp')
            ->where('user_id', $user_id)
            ->where('otp', $otp)
            ->where('status', 1)
            ->where('module_type', 3)
            ->where('otp_type', 2)
            ->first();

        if ($get_otp) {
            $update_otp_status = DB::table('tbl_otp')
                ->where('id', $get_otp->id)
                ->update(['status' => 2]);
        }

        if ($get_otp) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function update_kyc_status($id)
    {
        $update_kyc_status = DB::table('kyc_processes')->where('id', $id)->update(['kyc_status' => $_POST['kyc_status']]);
        if ($update_kyc_status) {
            return redirect()->route('view.member.kyc', $id)->with('success', 'Kyc Status Update successfully.');
        } else {
            return redirect()->route('view.member.kyc', $id)->with('errors', 'Error');
        }
    }
}
