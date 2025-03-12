<?php

namespace App\Http\Controllers;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class MessageController extends Controller
{
    public function getMessages(Request $request)
    {
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
        ]);
        $messages = Message::where(function ($query) use ($request) {
            $query->where('sender_id', $request->sender_id)
                ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('sender_id', $request->receiver_id)
                ->where('receiver_id', $request->sender_id);
        })
        ->orderBy('created_at', 'asc')
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Fetch Message Successfully','data'=>$messages]);

    }

    public function sendMessage(Request $request)
    {

        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required|string',
        ]);
        $msg = new Message();
        $msg->sender_id = $request->sender_id;
        $msg->receiver_id = $request->receiver_id;
        $msg->message = $request->message;
        $msg->save();
        if($msg){
            return response()->json(['status' => 'OK', 'message' => 'Message Sent successfully']);
        }
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
        ]);
        Message::where('sender_id', $request->sender_id)
            ->where('receiver_id', $request->receiver_id)
            ->update(['is_read' => true]);
        return response()->json(['status' => 'OK', 'message' => 'Messages marked as read.']);

    }

    public function fetchUsers(Request $request){

        $fetch_bookings = DB::table('tbl_pet_bookings')->where('status',1)->whereIn('booking_status',[2,4]);
        if($request->user->role_id == 3){
            $fetch_bookings->where('accept_user_id',$request->user->id);
        }
        if($request->user->role_id == 5){
            $fetch_bookings->where('customer_id',$request->user->id);
        }
        $fetch_booking = $fetch_bookings->get();
        $accept_ids = '';
        $customer_ids = '';
        foreach($fetch_booking as $book){
            $accept_ids .= $book->accept_user_id.',';
            $customer_ids .= $book->customer_id.',';
        }
        $accept_id_string = rtrim($accept_ids, ',');
        $accept_id = explode(',', $accept_id_string);
        $customer_id_string = rtrim($customer_ids, ',');
        $customer_id = explode(',', $customer_id_string);
        $users = DB::table('users as a')
            ->where('a.status', 1);
            if($request->user->role_id == 5){
                $users->whereIn('a.id',$accept_id);
            }
            if($request->user->role_id == 3){

                $users->whereIn('a.id',$customer_id);
            }
            $get_users = $users->orderBy('a.id', 'desc')
            ->get();
        return response()->json(['status' => 'OK', 'message'=>'Fetch User Successfully','data' => $get_users]);
    }
}
