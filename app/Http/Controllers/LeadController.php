<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Loan_request;
use App\Models\Member;
use App\Helpers\Global_helper as GlobalHelper;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;
use App\Models\Providers;
use App\Models\Route;

class LeadController extends Controller
{

    public function index()
    {

        $title = "Lead List";
        $alllead = DB::table('loan_requests')->leftJoin('users', 'loan_requests.user_id', '=', 'users.id')->leftJoin('providers', 'providers.id', '=', 'loan_requests.service_no')->select('loan_requests.*', 'users.name as username', 'providers.title as service_name')->where('loan_requests.status', '!=', '3')->where('loan_requests.loan_status', '!=', 5)->orderBy('loan_requests.id', 'desc')->get();
        return view('lead.index', compact('title', 'alllead'));
    }

    public function qualified_leads()
    {

        $title = "Qualified Lead List";
        $alllead = DB::table('kyc_leads')->join('users', 'kyc_leads.user_id', '=', 'users.id')->join('loan_requests', 'kyc_leads.loan_request_id', '=', 'loan_requests.id')->select('kyc_leads.*', 'users.name as username', 'loan_requests.name  as lead_name', 'loan_requests.mobile  as lead_mobile', 'loan_requests.loan_amount  as lead_loan_amount', 'loan_requests.address  as lead_address', 'loan_requests.work  as lead_work', 'loan_requests.reason_of_loan  as lead_reason_of_loan')->where('kyc_leads.status', '!=', '3')->orderBy('kyc_leads.id', 'desc')->get();
        return view('lead.qualified_leads', compact('title', 'alllead'));
    }

    public function admin_lead()
    {
        $title = "Lead List";
        $alllead = DB::table('loan_requests')->leftJoin('users', 'loan_requests.user_id', '=', 'users.id')->select('loan_requests.*', 'users.name as username')->where('loan_requests.status', '!=', '3')->where('loan_requests.loan_status', '!=', 5)->orderBy('loan_requests.id', 'desc')->get();
        return view('lead.index_admin', compact('title', 'alllead'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {

            $request->validate([
                'name' => 'required|string|max:255',
                'reason_of_loan' => 'required|string|max:500',
                'loan_amount' => 'required',
                // 'address' => 'required|string|max:500',
                // 'email' => [
                //     'required',
                //     'email',
                //     'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                // ],
                'mobile' => [
                    'required',
                    'regex:/^[6-9]\d{9}$/'
                ],
                // 'zipcode' => [
                //     'required',
                //     'regex:/^\d{6}$/'
                // ],
            ]);
            $lead = new Loan_request();
            $lead->user_id = Auth::user()->id;
            $lead->route_id = $request->route_id;
            $lead->service_no = $request->service;
            $lead->lead_create_date = $request->date;
            $lead->name = $request->name;
            $lead->work = $request->work;
            $lead->mobile = $request->mobile;
            $lead->work_address = $request->work_address;
            $lead->cheque = $request->cheque;
            $lead->shop_thiya = $request->shop_thiya;
            $lead->home_type = $request->home;
            $lead->home_address = $request->home_address;
            $lead->file_hai = $request->file_hai;
            $lead->loan_amount = $request->loan_amount;
            $lead->tut = $request->tut;
            $lead->balance = $request->balance;
            $lead->plus_day = $request->plus_minus_day;
            $lead->old_loan = $request->old_loan;
            $lead->loan_type = $request->loan_type;
            $lead->file_no = $request->file_no;
            $lead->ser_no = $request->ser;
            $lead->rn_no = $request->r_n;
            $lead->amount = $request->amount;
            $lead->accountant_sign = $request->accountant_sign;
            $lead->guarantor = $request->guarantor;
            $lead->guarantor_name = $request->guarantor_name;
            $lead->remark = $request->reason_of_loan;
            $lead->loan_status = 3;
            $lead->save();
            $insert_id = $lead->id;
            DB::table('notes')->insert(['loan_request_id' => $insert_id, 'user_id' => Auth::user()->id, 'loan_status' => 1, 'title' => "Create Lead"]);
            return redirect()->route('lead')->with('success', 'Lead Added Successfully');
        }
        $title = "Add Lead";
        $get_user = Member::where('status', 1)->get();
        $get_service = Providers::where('status', 1)->get();
        $get_route = Route::where('status', 1)->get();
        return view('lead.create', compact('title', 'get_user', 'get_service', 'get_route'));
    }

    public function edit($id)
    {
        $title = "Edit Lead";
        $get_lead = Loan_request::where('status', '!=', 3)->where('id', $id)->first();
        $get_user = Member::where('status', 1)->where('id', '!=', 1)->get();
        return view('lead.create', compact('title', 'get_lead', 'get_user'));
    }

    public function view($id)
    {
        $get_route = Route::where('status', 1)->get();
        $user_id = Auth::user()->id;
        $get_note = DB::table('notes')->where('loan_request_id', $id)->where('title', 'View Lead')->where('user_id', $user_id)->first();

        if (!$get_note) {
            DB::table('notes')->insert(['loan_request_id' => $id, 'user_id' => $user_id, 'loan_status' => 2, 'title' => "View Lead"]);
            Loan_request::where('id', $id)->update(['loan_status' => 2]);
        }
        $title = "View Lead";
        $get_lead_1 = Loan_request::where('status', '!=', 3)->where('id', $id)->first();
        $get_user = Member::where('status', 1)->where('id', $get_lead_1->user_id)->first();
        $get_lead = DB::table('loan_requests')->leftJoin('users', 'loan_requests.user_id', '=', 'users.id')->leftJoin('providers', 'providers.id', '=', 'loan_requests.service_no')->select('loan_requests.*', 'users.name as username', 'providers.title as service_name')->where('loan_requests.status', '!=', '3')->where('loan_requests.loan_status', '!=', 5)->where('loan_requests.id', $id)->orderBy('loan_requests.id', 'desc')->first();
        return view('lead.view', compact('title', 'get_lead', 'get_user','get_route'));
    }

    public function kyclead_view($id)
    {

        $title = "Kyc Lead View";
        $get_lead = DB::table('kyc_leads')
            ->leftJoin('users', 'kyc_leads.user_id', '=', 'users.id')
            ->leftJoin('users as b', 'kyc_leads.agent_id', '=', 'b.id')
            ->leftJoin('routes', 'routes.id', '=', 'kyc_leads.route_id')
            ->leftJoin('kyc_leads_guarantor', 'kyc_leads_guarantor.kyc_id', '=', 'kyc_leads.id')
            ->leftJoin('loan_requests', 'kyc_leads.loan_request_id', '=', 'loan_requests.id')
            ->select(
                'kyc_leads.*',
                'users.name as username',
                'b.name as agent_name',
                'routes.route as route_no',
                'loan_requests.lead_create_date as lead_date',
                // 'loan_requests.route_id as lead_route_id',
                'loan_requests.file_no as lead_file_no',
                'loan_requests.home_type as lead_home_type',
                'loan_requests.cheque as lead_cheque',
                'loan_requests.home_address as lead_home_address',
                'loan_requests.name as lead_name',
                'loan_requests.work as lead_work',
                'loan_requests.mobile as lead_mobile',
                'loan_requests.loan_amount as lead_loan_amount',
                'loan_requests.address as lead_address',
                'loan_requests.reason_of_loan as lead_reason_of_loan',
                'kyc_leads_guarantor.id as guarantor_id',
                'kyc_leads_guarantor.kyc_id as guarantor_kyc_id',
                'kyc_leads_guarantor.name as guarantor_name',
                'kyc_leads_guarantor.son_of as guarantor_son_of',
                'kyc_leads_guarantor.type_of_work as guarantor_type_of_work',
                'kyc_leads_guarantor.shop_address as guarantor_shop_address',
                'kyc_leads_guarantor.shop_type as guarantor_shop_type',
                'kyc_leads_guarantor.mobile_no_1 as guarantor_mobile_no_1',
                'kyc_leads_guarantor.mobile_no_2 as guarantor_mobile_no_2',
                'kyc_leads_guarantor.home_address as guarantor_home_address',
                'kyc_leads_guarantor.land_load as guarantor_land_load'
            )
            ->where('kyc_leads.status', '!=', '3')
            ->where('kyc_leads.id', $id)
            ->orderBy('kyc_leads.id', 'desc')
            ->get();
        $loan_detail = DB::table('loans')->where('status', 1)->where('kyc_id', $id)->first();
        return view('lead.kycview', compact('title', 'get_lead', 'loan_detail'));
    }

    public function update(Request $request)
    {





        if ($request->loan_status == "approved") {
            $request->validate([
                'name' => 'required|string|max:255',
                'reason_of_loan' => 'required|string|max:500',
                'loan_amount' => 'required',
                'user_id' => 'required',
                'address' => 'required|string|max:500',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'mobile' => [
                    'required',
                    'regex:/^[6-9]\d{9}$/'
                ],
                'zipcode' => [
                    'required',
                    'regex:/^\d{6}$/'
                ],
                'frequency' => 'required',
                'rate_of_interest' => 'required|integer',
                'tenure' => 'required|integer',
                'process_charge' => 'required|integer',
                'file_charge' => 'required|integer',
                'other_charges_1' => 'required|integer',
                'other_charges_2' => 'required|integer',
                'other_charges_3' => 'required|integer',
                'other_charges_4' => 'required|integer',
                'other_charges_5' => 'required|integer',
                'start_date' => 'required'
            ]);
        }


        if ($request->loan_status != "approved") {
            $request->validate([
                'name' => 'required|string|max:255',
                'reason_of_loan' => 'required|string|max:500',
                'loan_amount' => 'required',
                'user_id' => 'required',
                'address' => 'required|string|max:500',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'mobile' => [
                    'required',
                    'regex:/^[6-9]\d{9}$/'
                ],
                'zipcode' => [
                    'required',
                    'regex:/^\d{6}$/'
                ],
            ]);
        }

        $lead = Loan_request::findOrFail($request->hidden_id);
        $lead->user_id = $request->user_id;
        $lead->name = $request->name;
        $lead->email = $request->email;
        $lead->mobile = $request->mobile;
        if ($request->loan_status == "approved") {
            $lead->loan_status = 5;
        }
        $lead->loan_amount = $request->loan_amount;
        $lead->reason_of_loan = $request->reason_of_loan;
        $lead->zip_code = $request->zipcode;
        $lead->address = $request->address;
        $lead->save();
        $genrate_loan_number = rand(9999999999, 0000000000);
        if ($request->loan_status == "approved") {

            $insertedId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'aadhar_no' => $lead->aadhar_no,
                'mobile_no' => $request->mobile,
                'role_id' => 4
            ]);

            $disbrused_amount = $request->loan_amount - ($request->file_charge + $request->other_charges_1 + $request->other_charges_2 + $request->other_charges_3 + $request->other_charges_4 + $request->other_charges_5);
            $emiData = GlobalHelper::calculateEMI($request->loan_amount, $request->rate_of_interest, $request->tenure);
            $emi_amount = "";
            switch ($request->frequency) {
                case '1':
                    $emi_amount = $emiData['daily_emi'];
                    break;
                case '2':
                    $emi_amount = $emiData['weekly_emi'];
                    break;
                case '3':
                    $emi_amount = $emiData['monthly_emi'];
                    break;
            }
            $disbrused_amount_ = $disbrused_amount;
            $pending_amount   = number_format((floatval(str_replace(',', '', $emi_amount)) * floatval($request->tenure)), 2);
            $emi_amount_   = $emi_amount;
            $loan_start_date  = date('Y-m-d', strtotime($request->start_date));
            // echo $loan_start_date; die;

            DB::table('loans')->insert([
                'loan_request_id' => $request->hidden_id,
                'user_id' => $insertedId,
                'loan_number' => $genrate_loan_number,
                'amount' => $request->loan_amount,
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
                'disbrused_amount' => $disbrused_amount_,
                'pending_amount' => $pending_amount,
                'emi_amount' => $emi_amount_,
                'loan_start_date' => $loan_start_date,
                'loan_status' => 2,
            ]);
        }

        return redirect()->route('lead')->with('success', 'Lead Update Successfully');
    }


    public function destroy($id)
    {
        $lead = Loan_request::findOrFail($id);
        $lead->status = 3;
        $lead->update();
        return redirect()->route('lead')->with('success', 'Lead deleted successfully.');
    }

    public function viewright_modal(Request $request)
    {
        $lead_id = $request->lead_id;

        // Fetching notes with users
        $notes = DB::table('notes')
            ->leftJoin('users', 'notes.user_id', '=', 'users.id')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('notes.*', 'users.name as username', 'roles.title as role_name')
            ->where('notes.loan_request_id', $lead_id)
            ->where('notes.status', 1)
            ->orderBy('notes.id', 'asc')
            ->get();

        $html = ''; // Initialize the HTML variable

        if (!empty($notes)) {
            foreach ($notes as $note) {
                // Switch for loan status
                switch ($note->loan_status) {
                    case 1:
                        $loan_status = "Pending";
                        $class = "warning";
                        $added_by = "Created By";
                        break;
                    case 2:
                        $loan_status = "View";
                        $class = "primary";
                        $added_by = "Viewed By";
                        break;
                    case 3:
                        $loan_status = "Under Discussion";
                        $class = "secondary";
                        $added_by = "Discussion By";
                        break;
                    case 4:
                        $loan_status = "Pending KYC";
                        $class = "danger";
                        $added_by = "Discussion By";
                        break;
                    case 5:
                        $loan_status = "Qualified";
                        $added_by = "Qualified By";
                        $class = "success";
                        break;
                    case 6:
                        $loan_status = "Rejected";
                        $added_by = "Rejected By";
                        $class = "danger"; // Corrected typo "dangeer"
                        break;
                    default:
                        $loan_status = "Unknown";
                        $class = "light";
                        $added_by = '';
                        break;
                }

                // Build HTML for each note using the new structure with loan status badge
                $html .= '
            <div class="status submitted">
                <div class="status-dot"></div>
                <div class="status-text">
                    <strong>' . htmlspecialchars($note->title) . '</strong><br>
                    <small>' . str_replace('By', ' ', $added_by) . ' At : ' . date('d F Y h:i A', strtotime($note->created_at)) . '</small><br>
                    <small>' . $added_by . '  : ' . ucwords(htmlspecialchars($note->username)) . ' (' . $note->role_name . ')' . '</small><br>
                    <small>Lead Status :
                        <span class="badge bg-' . $class . ' rounded-pill">' . htmlspecialchars(str_replace('_', ' ', $loan_status)) . '</span>
                    </small>
                </div>
            </div>';
            }
        }

        echo $html; // Output the generated HTML
    }

    public function kyc_process(Request $request)
    {

        if ($request->kyc_status == 4) {
            $insert_reason = DB::table('kyc_reject_reasons')->insert([
                'kyc_id' => $request->hidden_id,
                'reason' => $request->reason,
            ]);
            DB::table('kyc_leads')->where('id', $request->hidden_id)->update(['kyc_status' => $request->kyc_status]);
            if ($insert_reason) {
                return redirect()->route('kyclead.view', ['id' => $request->hidden_id]);
            }
        } else {
            $lead = DB::table('kyc_leads')->where('id', $request->hidden_id)->first();

            if ($request->kyc_status == 3) {
                $request->validate([
                    'frequency' => 'required',
                    'rate_of_interest' => 'required|integer',
                    'tenure' => 'required|integer',
                    'process_charge' => 'required|integer',
                    'file_charge' => 'required|integer',
                    'other_charges_1' => 'required|integer',
                    'other_charges_2' => 'required|integer',
                    'other_charges_3' => 'required|integer',
                    'other_charges_4' => 'required|integer',
                    'other_charges_5' => 'required|integer',
                    'start_date' => 'required'
                ]);
            }

            if ($request->kyc_status == 3) {
                $check_exist_user = DB::table('users')->where('aadhar_no', $lead->aadhar_no)->orWhere('mobile_no', $lead->mobile_no)->first();
                if ($check_exist_user) {
                    $insertedId = $check_exist_user->id;
                } else {
                    $loan_request_detail =  DB::table('loan_requests')->where('id', $lead->loan_request_id)->where('status', 1)->first();

                    $insertedId = DB::table('users')->insertGetId([
                        'name' => $lead->customer_name,
                        'aadhar_no' => $lead->aadhar_no,
                        'email' => $loan_request_detail->email,
                        'mobile_no' => $lead->mobile_no,
                        'role_id' => 4
                    ]);
                }
                $disbrused_amount = $lead->loan_amount - ($request->file_charge + $request->other_charges_1 + $request->other_charges_2 + $request->other_charges_3 + $request->other_charges_4 + $request->other_charges_5);
                $emiData = GlobalHelper::calculateEMI($lead->loan_amount, $request->rate_of_interest, $request->tenure);
                $emi_amount = "";
                switch ($request->frequency) {
                    case '1':
                        $emi_amount = $emiData['daily_emi'];
                        break;
                    case '2':
                        $emi_amount = $emiData['weekly_emi'];
                        break;
                    case '3':
                        $emi_amount = $emiData['monthly_emi'];
                        break;
                }
                $disbrused_amount_ = $disbrused_amount;
                $pending_amount   = number_format((floatval(str_replace(',', '', $emi_amount)) * floatval($request->tenure)), 2);
                $emi_amount_   = $emi_amount;
                $loan_start_date  = date('Y-m-d', strtotime($request->start_date));
                // echo $loan_start_date; die;
                $genrate_loan_number = rand(999999999999, 000000000000);

                DB::table('loans')->insert([
                    'kyc_id' => $request->hidden_id,
                    'user_id' => $insertedId,
                    'loan_number' => $genrate_loan_number,
                    'amount' => $lead->loan_amount,
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
                    'disbrused_amount' => $disbrused_amount_,
                    'pending_amount' => $pending_amount,
                    'emi_amount' => $emi_amount_,
                    'loan_start_date' => $loan_start_date,
                    'loan_status' => 2,
                ]);

                DB::table('kyc_leads')->where('id', $request->hidden_id)->update(['kyc_status' => $request->kyc_status]);
                return redirect()->route('kyclead.view', ['id' => $request->hidden_id])->with('success', 'kyc successfully updated');
            }
        }
    }
}
