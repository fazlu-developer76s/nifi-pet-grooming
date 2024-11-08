<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Userlocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $decode_otp = isset($_GET['request']) ? base64_decode($_GET['request']): '';
        $check_last_otp = DB::table('tbl_otp')->where('otp',$decode_otp)->where('status',2)->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        if($check_last_otp){
            $next($request);
        }else{
            $otp =  str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            DB::table('tbl_otp')->insert([
                'user_id' => Auth::user()->id,
                'module_type' => 3,
                'otp' => $otp,
                'otp_type' => 2,
                'field_value' => "access user location",
                'field_value' => "access user location",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $email = "fazlu.developer@gmail.com";
            Mail::to($email)->send(new OtpMail($otp));
        }

        return $next($request);
    }
}
