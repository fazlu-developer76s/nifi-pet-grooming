<?php

namespace App\Http\Controllers;

use App\Models\Loan_request;
use Illuminate\Http\Request;
use DB;

class NotesController extends Controller
{

    public function create(Request $request)
    {

        // $get_lead = DB::table('loan_requests')->where('id',$request->lead_id)->first();
        // $get_route_id = DB::table('routezips')->where('status',1)->where('zip_code',$get_lead->zip_code)->first();
        // if(!$get_route_id){
        //     echo 2; die;
        // }

        if($request->hidden_id){
            $note_id = $request->hidden_id;
            $update_note = DB::table('notes')->where('id', $note_id)->update(['title' => $request->title]);
            if ($update_note) {
                return response()->json(['message' => 'Note updated successfully.'], 200);
            }
        }
        $user_id = $request->user_id;
        $lead_id = $request->lead_id;
        $status = $request->status;
        $title = $request->title;
        $insert_note = DB::table('notes')->insert(['user_id' => $user_id, 'loan_request_id' => $lead_id, 'title' => $title,'loan_status'=> $status]);
        DB::table('loan_requests')->where('id',$lead_id)->update(['loan_status'=>$status]);

        if($request->status == 5){
            DB::table('kyc_leads')->insert([
                'loan_request_id' => $request->lead_id,
                'user_id' => $request->user_id,
                'route_id' => $request->route_id
            ]);
            echo 1; die;
        }
        if ($insert_note) {
            return response()->json(['message' => 'Note added successfully.'], 200);
        }
    }

    public function fetch_notes(Request $request)
{
    $lead_id = $request->lead_id;

    // Fetching notes with users
    $notes = DB::table('notes')
        ->leftJoin('users', 'notes.user_id', '=', 'users.id')
        ->leftJoin('roles','users.role_id','=','roles.id')
        ->select('notes.*', 'users.name as username','roles.title as role_name')
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
                    $added_by = "Disscussion By";
                    break;
                case 4:
                    $loan_status = "Pending KYC";
                    $class = "danger";
                    $added_by = "Disscussion By";
                    break;
                case 5:
                    $loan_status = "Qualified";
                    $class = "success";
                    $added_by = "Qualified By";
                    break;
                case 6:
                    $loan_status = "Rejected";
                    $class = "danger"; // Corrected typo "dangeer"
                    $added_by = "Rejected By";
                    break;
                default:
                    $loan_status = "Unknown";
                    $class = "light";
                    $added_by = " ";
                    break;
            }

            // Build HTML for each note with proper alignment and Bootstrap classes
            $html .= '
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0">Title : ' . $note->title . '</p>
                        <p>'.str_replace('By',' ',$added_by).' At: ' . date('d F Y h:i A', strtotime($note->created_at)) . '</p>
                        <small>'.$added_by.': ' . ucwords($note->username) .' ('.$note->role_name.')'. '</small>
                    </div>
                    <span class="badge bg-' . $class . ' rounded-pill">' . str_replace('_', ' ', $loan_status) . '</span>
                </div>
            </li>';
        }
    }

    echo $html; // Output the generated HTML
}




    public function delete_notes(Request $request){
        $note_id = $request->note_id;
        $delete_note = DB::table('notes')->where('id', $note_id)->update(['status' => 3]);
        if($delete_note){
            return response()->json(['message' => 'Note deleted successfully.'], 200);
        }
    }

    public function notes_disscuss(Request $request){

        $id = $request->id;
        $user_id = $request->user_id;
        $get_note = DB::table('notes')->where('loan_request_id',$id)->where('title','View Lead')->where('user_id',$user_id)->first();
        if($get_note){
            DB::table('notes')->insert(['loan_request_id'=>$id,'user_id'=>$user_id,'loan_status'=>3,'title'=>"Under Disscussion"]);
            DB::table('loan_requests')->where('id', $id)->update(['loan_status' => 3]);

        }
    }
}
