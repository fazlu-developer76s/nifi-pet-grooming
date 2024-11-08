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
        // $allmember = Member::where('status','!=',3)->where('role_id','!=',1)->orderBy('id','desc')->get();
        $allmember = DB::table('users')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->select('users.*', 'roles.title')->where('users.role_id', '!=', 4)->get();
        return view('member.index', compact('title', 'allmember'));
    }
    public function borrower()
    {

        $title = "Member List";
        $user_id = Auth::user()->id;
        // $get_otp_status = DB::table('tbl_otp')->where('user_id',$user_id)->where('module_type',3)->orderBy('id','desc')->limit(1)->get()[0];
        $get_otp_status = DB::table('tbl_otp')
            ->where('user_id', $user_id)
            ->where('module_type', 3)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();
        $allmember = DB::table('users')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->select('users.*', 'roles.title')->where('users.role_id', 4)->get();
        return view('member.index', compact('title', 'allmember', 'get_otp_status'));
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
            $member->aadhar_no = $request->aadhar_no;
            $member->status = $request->status;
            $member->password = Hash::make($request->password);
            $member->save();
            $insert_id = $member->id;
            return redirect()->route('member')->with('success', 'Member Added Successfully');
        }

        $title = "Add Member";
        $get_role = Roles::where('status', 1)->where('id', '!=', 1)->get();
        $allroute = Route::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('member.create', compact('title', 'get_role', 'allroute'));
    }

    public function edit($id)
    {
        $title = "Edit Member";
        $allroute = Route::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        $get_member = Member::where('status', '!=', 3)->where('role_id', '!=', 1)->where('id', $id)->first();
        $get_role = Roles::where('status', 1)->where('id', '!=', 1)->get();
        return view('member.create', compact('title', 'get_member', 'get_role', 'allroute'));
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
            // Exclude the current member from the check
            $query->where('id', '!=', $id);
        }

        // Check for existing email, mobile number, or Aadhar number
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
}
