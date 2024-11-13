<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use DB;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            if ($decoded->exp < time()) {
                return response()->json(['error' => 'Token has expired'], 401);
            }
            $request->auth = $decoded;
            $request->user = User::find($decoded->sub);
            if($this->CheckToken($request->user->id,$token)) {

            if($request->user->status==2)
            {
                return response()->json([
                  'status' => 'error',
                  'message' => 'User Account is deactivated. Please contact to admin',
                  'code' => 401
                ]);
            }
            else if ($request->user->status==3 || $request->user->status==4)
            {
                return response()->json([
                  'status' => 'error',
                  'message' => 'User Account is deleted. Please contact to admin',
                  'code' => 401
                ]);
            }
          }
          else
          {
            return response()->json([
              'status' => 'error',
              'message' => 'Token is invalid or expired',
              'code' => 401
            ]);
            }
        } catch (Exception $e) {
            if($this->CheckToken(null,$token))
            {
                $this->expireToken($token);
                return response()->json(['error' => 'Invalid token'], 401);
            }
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }

    public function CheckToken($user_id="",$token)
    {
        $checkToken = DB::table('tbl_token');
        if($user_id)
        {
            $checkToken->where('user_id', $user_id);

        }
        $checkToken->where('token', $token);
        $checkToken->where('status', 1);
        $tokenDetail =     $checkToken->first();

        if($tokenDetail)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function expireToken($token)
    {
        $expireToken = DB::table('tbl_token')
            ->where('token', $token)
            ->where('status', 1)
            ->update(['status' => 2, 'updated_at' => now()]);
        if($expireToken)
        {
            return true;
        }
    }
}
