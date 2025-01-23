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
        $role_id='';
        if($request->type == 1){
            $role_id = 3;
        }
        if($request->type == 2){
            $role_id = 5;
        }
        $users = DB::table('users as a')->join('roles as b','a.role_id','=','b.id')->select('a.*','b.title as role_name')->where('a.status',1)->where('b.status',1)->where('a.role_id',$role_id)->get();
        return response()->json(['status' => 'OK', 'message'=>'Fetch User Successfully','data' => $users]);
    }
}
