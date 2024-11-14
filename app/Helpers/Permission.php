<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\Aepsreport;
use App\Models\UserPermission;
use App\Models\Apilog;
use App\Models\Scheme;
use App\Models\Pindata;
use App\Models\Commission;
use App\Models\User;
use App\Models\Report;
use App\Models\Utiid;
use App\Models\Provider;
use App\Models\Packagecommission;
use App\Models\Microatmreport;
use App\Models\Package;
use App\Models\Callbackresponse;

class Permission
{
    /**
     * @param String $permissions
     *
     * @return boolean
     */

    // public static function can($permission , $id="none") {
    //     if($id == "none"){
    //         $id = session("loginid");
    //     }
    //     $user = User::where('id', $id)->first();

    //     if(is_array($permission)){
    //         $mypermissions = \DB::table('permissions')->whereIn('slug' ,$permission)->get(['id'])->toArray();
    //         if($mypermissions){
    //             foreach ($mypermissions as $value) {
    //                 $mypermissionss[] = $value->id;
    //             }
    //         }else{
    //             $mypermissionss = [];
    //         }
    //         $output = UserPermission::where('user_id', $id)->whereIn('permission_id', $mypermissionss)->count();
    //     }else{
    //         $mypermission = \DB::table('permissions')->where('slug' ,$permission)->first(['id']);
    //         if($mypermission){
    //             $output = UserPermission::where('user_id', $id)->where('permission_id', $mypermission->id)->count();
    //         }else{
    //             $output = 0;
    //         }
    //     }

    //     if($user->role->slug == "admin"){
    //         return true;
    //     }

    //     if($output > 0){
    //         return true;
    //     }

    //     return false;
    // }

    public static function getAccBalance($id, $wallet)
    {
        $mywallet = \DB::table('users')->where('id', $id)->first([$wallet]);

        $mywallet = (array) $mywallet;
        return $mywallet[$wallet];
    }

    public static function can($checkpermission, $id = "none")
    {
        if ($id == "none") {
            $id = session("loginid");
        }

        try {
            $permissions = unserialize(file_get_contents(storage_path('') . "/permissions/permission" . $id));
        } catch (\Exception $e) {
            $permissions = false;
        }
        if (!$permissions || sizeOf($permissions) == 0) {
            $mypermission =  \DB::table('user_permissions')->leftjoin("permissions", "permissions.id", "=", "user_permissions.permission_id")->where('user_permissions.user_id', $id)->get(["permissions.slug"]);
            $permissions = [];
            foreach ($mypermission as $permission) {
                $permissions[] = $permission->slug;
            }
            \Storage::disk("permission")->put("/permissions/permission" . $id, serialize($permissions));
        }

        if (is_array($checkpermission)) {
            if (array_intersect($checkpermission, $permissions)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (in_array($checkpermission, $permissions)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function companycan($permission, $id)
    {
        $company = \DB::table("companies")->where("id", $id)->first(["website"]);
        if ($company->website == "uat.e-banker.in") {
            return true;
        }

        $admin = \DB::table("users")->leftJoin('roles', 'roles.id', '=', 'users.role_id')->where('users.company_id', $id)->whereIn('roles.slug', ['whitelable', 'admin'])->first(['users.id', 'roles.slug as roleslug']);

        if ($admin) {
            if ($admin->roleslug == "admin" || \Myhelper::can($permission, $admin->id)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function hasRole($roles)
    {
        if (\Auth::check()) {
            if (is_array($roles)) {
                if (in_array(\Auth::user()->role->slug, $roles)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (\Auth::user()->role->slug == $roles) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function hasNotRole($roles)
    {
        if (\Auth::check()) {
            if (is_array($roles)) {
                if (!in_array(\Auth::user()->role->slug, $roles)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (\Auth::user()->role->slug != $roles) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function apiLog($url, $modal, $txnid, $header, $request, $response)
    {
        try {
            $apiresponse = Apilog::create([
                "url" => $url,
                "modal" => $modal,
                "txnid" => $txnid,
                "header" => $header,
                "request" => $request,
                "response" => $response
            ]);
        } catch (\Exception $e) {
            $apiresponse = "error";
        }
        return $apiresponse;
    }

    public static function mail($view, $data, $mailto, $name, $mailvia, $namevia, $subject)
    {
        \Mail::send($view, $data, function ($message) use ($mailto, $name, $mailvia, $namevia, $subject) {
            $message->to($mailto, $name)->subject($subject);
            $message->from($mailvia, $namevia);
        });

        if (\Mail::failures()) {
            return "fail";
        }
        return "success";
    }

    public static function notification($product, $mobile, $name, $email, $resend = "no")
    {
        // $realIP = file_get_contents("http://ipecho.net/plain"))
        // print_r($_SERVER['SERVER_ADDR']);die;
        // print_r($_SERVER['REMOTE_ADDR']);die;

        $otpSend = \DB::table('password_resets')->where("mobile", $mobile)->where("activity", $product)->first();




        if (!$otpSend || $otpSend->resend < 3) {
            if ($otpSend && $otpSend->last_activity > time() - 120) {
                return "Otp can be resend after 2 minutes";
            }

            $otp = rand(111111, 999999);
            $emailotp = rand(111111, 999999);
            $pin = rand(1111, 9999);
            $otpmailid   = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
            $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
            $company = \DB::table('companies')->where('website', $_SERVER['SERVER_NAME'])->first();
            switch ($product) {
                case 'login':
                    $msg = "Dear " . $name . " Your OTP For " . $product . " in " . $company->companyname . " is " . $otp . " Valid For 10 Minutes. we request you to don't share with anyone .Thanks NSAFPL";
                    //$msg = "Dear partner, your login OTP for antila fintech is ".$otp.", please do not share otp with anyone.";
                    $send = \Myhelper::otp($mobile, $msg, "1707164805234023036");

                    try {
                        $content = "<html><head></head><body><p style='margin-top:33px;line-height: 1.5;font-weight: 100;font-size: 20px;'>Dear <b>" . $name . "</b> <br> Your One time password for Login is <b> " . $otp . " </b> walid for next 10 minutes . Don't share with anyone.</p></body></html>";

                        $send =  \Myhelper::mailsend($email, $content, "Login OTP", $name, $company->companyname);
                    } catch (\Exception $e) {
                    }
                    break;

                case 'device':
                    $msg = "Dear partner, your login OTP for antila fintech is " . $otp . ", please do not share otp with anyone.";
                    $send = \Myhelper::otp($mobile, $msg, "1207161726561634222");

                    try {
                        \Myhelper::mail('mail.otp', ["name" => $name, "otp" => $otp, "type" => "Device Change"], $email, $name, $otpmailid->value, $otpmailname->value, "Otp Login");
                    } catch (\Exception $e) {
                    }
                    break;

                case 'addbank':
                    $msg = "Dear Customer, " . $otp . " is the otp to add bank accoount for settlement. Do not disclose it to anyone. Antlia Fintech";
                    $send = \Myhelper::otp($mobile, $msg, "1207165519380036667");

                    try {
                        \Myhelper::mail('mail.otp', ["name" => $name, "otp" => $otp, "type" => "Add Settlement Bank"], $email, $name, $otpmailid->value, $otpmailname->value, "Otp Login");
                    } catch (\Exception $e) {
                    }
                    break;

                case 'tpin':
                    $content = "Dear " . $name . " Your OTP For conformation in Tpin is " . $otp . " Valid For 10 Minutes. we request you to don't share with anyone .Thanks NSAFPL";
                    $send = \Myhelper::otp($mobile, $content, "1707164805234023036");

                    try {
                        \Myhelper::mail('mail.otp', ["name" => $name, "otp" => $otp, "type" => "T-Pin"], $email, $name, $otpmailid->value, $otpmailname->value, "T-Pin Reset");
                    } catch (\Exception $e) {
                    }
                    break;

                case 'password':
                    $content = "Dear partner, your password reset token for antlia is " . $otp;
                    $send    = \Myhelper::otp($mobile, $content, "1207161823102572004");
                    try {
                        \Myhelper::mail('mail.otp', ["name" => $name, "otp" => $otp, "type" => "Password Reset"], $email, $name, $otpmailid->value, $otpmailname->value, "Password Reset");
                    } catch (\Exception $e) {
                    }
                    break;

                case 'welcome':

                    $user = \DB::table('users')->where('mobile', $mobile)->first();
                    $apptoken = Pindata::create([
                        'pin' => \Myhelper::encrypt($pin, $company->encryption_key),
                        'user_id' => $user->id,
                        'attempt' => 0,
                        'status'  => "active"
                    ]);

                    $content = "Dear $name your registration request is processed successfully in $company->companyname ,your ID is $mobile password is $mobile login pin is $pin.don't share with anyone . NSAFPL";
                    // $content = "Dear Partner, you have been successfully registered, your username is ".$mobile." & password is ".$mobile." Regards Antlia Fintech.";
                    $send = \Myhelper::otp($mobile, $content, "1707164805205021492");
                    try {
                        $content = "<html><head></head><body><p style='margin-top:33px;line-height: 1.5;font-weight: 100;font-size: 20px;'>Dear <b>" . $name . "</b> <br> Welcome to  <b> " . $company->companyname . " </b><br> A Digital world of <b> New Edge Technology. </b> Below is your Account login Details<br><b>Account Name:$name</b><br><b>Login ID:$mobile</b><br><b>User ID:$email</b><br><b>User Password:$mobile</b><br><b>User Pin:$pin</b></p></body></html>";

                        $send =  \Myhelper::mailsend($email, $content, "Welcome mail from " . $company->companyname, $name, $company->companyname);
                    } catch (\Exception $e) {
                    }
                    break;

                case 'signup':
                    $content = "Dear " . $name . " Your OTP For conformation in signup is " . $otp . " Valid For 10 Minutes. we request you to don't share with anyone .Thanks NSAFPL";
                    $send = \Myhelper::otp($mobile, $content, "1707164805234023036");

                    try {
                        $content = "<html><head></head><body><p style='margin-top:33px;line-height: 1.5;font-weight: 100;font-size: 20px;'>Dear <b>" . $name . "</b> <br> Your One time password for signup is <b> " . $emailotp . " </b> walid for next 5 minutes . Don't share with anyone.</p></body></html>";

                        $send =  \Myhelper::mailsend($email, $content, "Email verification  otp", $name, $company->companyname);
                    } catch (\Exception $e) {
                    }
                    break;

                case 'ip':
                    $content = "Dear " . $name . " Your OTP For conformation in ip whitelist is " . $otp . " Valid For 10 Minutes. we request you to don't share with anyone .Thanks NSAFPL";
                    $send = \Myhelper::otp($mobile, $content, "1707164805234023036");
                    try {
                        \Myhelper::mail('mail.otp', ["name" => $name, "otp" => $otp, "type" => "Ip Whitelist"], $email, $name, $otpmailid->value, $otpmailname->value, "Otp Login");
                    } catch (\Exception $e) {
                    }
                    break;
            }

            if ($send == "success" && $product != "welcome") {
                if (!$otpSend) {
                    \DB::table('password_resets')->insert([
                        'mobile'   => $mobile,
                        'email'   => $email,
                        'token'    => \Myhelper::encrypt($otp, $company->encryption_key),
                        'token1'    => \Myhelper::encrypt($emailotp, $company->encryption_key),
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        "last_activity" => time(),
                        "activity" => $product
                    ]);
                } else {
                    \DB::table('password_resets')->where("mobile", $mobile)->where("activity", $product)->update([
                        'mobile'   => $mobile,
                        'email'   => $email,
                        'token'    => \Myhelper::encrypt($otp, $company->encryption_key),
                        'token1'    => \Myhelper::encrypt($emailotp, $company->encryption_key),
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        "last_activity" => time(),
                        "resend"   => $otpSend->resend + 1
                    ]);
                }
            }
            return $send;
        } else {
            return "Otp limit exceed, please contact your service provider";
        }
    }

    public static function otpValidate($activity, $mobile, $otp, $emailotp = null, $email = null)
    {
        $company = \DB::table('companies')->where('website', $_SERVER['SERVER_NAME'])->first();
        $otpSend = \DB::table('password_resets')->where("mobile", $mobile)
            ->where("token", \Myhelper::encrypt($otp, $company->encryption_key))
            ->first();

        if ($activity == 'signup') {
            $otpSendemail = \DB::table('password_resets')->where("email", $email)->where("activity", $activity)->where("token1", \Myhelper::encrypt($emailotp, $company->encryption_key))->first();
            if (! $otpSendemail) {

                return "failedmail";
            }
        }
        if ($otpSend) {
            if ($activity != "login") {
                \DB::table('password_resets')->where("id", $otpSend->id)->delete();
            }
            return "success";
        }


        return "failedmobile";
    }


    public static function get_location($ip)
    {
        $url = "http://ip-api.com/json/" . $id;
        $result = \Myhelper::curl($url, "GET", "", [], "no", "", "");
        if ($result['response'] != '') {
            $response = json_decode($result['response']);
            if ($response->ErrorCode == "0") {
                return "success";
            }
        }
        return "fail";
    }

    public static function otp($mobile, $content, $tempid)
    {
        $smsapi = \App\Models\Api::where('code', "smsapi")->first();
        $url = "http://sms.nerasoft.in/api/SmsApi/SendSingleApi?UserID=" . $smsapi->username . "&Password=" . $smsapi->password . "&SenderID=" . $smsapi->optional1 . "&Phno=" . $mobile . "&Msg=" . urlencode($content) . "&EntityID=" . $smsapi->optional2 . "&TemplateID=" . $tempid;

        $result   = \Myhelper::curl($url, "GET", "", [], "yes", "report", $mobile);
        $response = json_decode($result['response']);
        if (isset($response->Status) && $response->Status == "OK") {
            return "success";
        } else {
            return "fail";
        }
    }
    public static function mailsend($email, $content, $type, $name, $company)
    {
        $emailapi = \App\Models\Api::where('code', "emailapi")->first();
        $header = array(
            'api-key: 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',
            'Content-Type: application/json'
        );
        $body = '{
   "sender":{
      "name":"' . $company . '",
      "email":"no-reply@nifipay.in"
   },
   "to":[
      {
         "email":"' . $email . '",
         "name":"' . $name . '"
      }
   ],
   "subject":"' . $type . '",
   "htmlContent":"' . $content . '"
}';


        $result   = \Myhelper::curl($emailapi->url, "POST", $body, $header, "yes", "report", $email);







        $response = json_decode($result['response']);

        if (isset($response->messageId)) {
            return "success";
        } else {
            return "fail";
        }
    }

    public static function commission($report)
    {
        $insert = [
            'number' => $report->number,
            'mobile' => $report->mobile,
            'provider_id' => $report->provider_id,
            'api_id' => $report->api_id,
            'txnid'  => $report->id,
            'payid'  => $report->payid,
            'refno'  => $report->refno,
            'status' => 'success',
            'rtype'  => 'commission',
            'via'    => $report->via,
            'trans_type' => "credit",
            'product' => $report->product
        ];
        if ($report->product == "dmt") {
            $precommission = $report->charge - $report->profit - $report->gst;
        } elseif ($report->option1 == "AP" || $report->option1 == "M") {
            $precommission = $report->charge;
        } else {
            $precommission = $report->profit;
        }

        $provider = $report->provider_id;

        $api = \App\Models\Api::where('id', $report->api_id)->first();
        $parent = User::where('id', $report->user->parent_id)->first(['id', 'mainwallet', 'scheme_id', 'role_id', 'parent_id']);

        if ($parent->role->slug == "distributor") {
            $insert['balance']   = $parent->mainwallet;
            $insert['user_id']   = $parent->id;
            $insert['credit_by'] = $report->user_id;
            if ($report->provider->recharge1 != "payourtransfer") {
                $parentcommission = \Myhelper::getCommission($report->amount, $report->user->scheme_id, $provider, 'distributor');
            } else {
                $amount = $report->amount;
                for ($i = 1; $i < 6; $i++) {
                    if (5000 * ($i - 1) <= $amount  && $amount <= 5000 * $i) {
                        if ($amount == 5000 * $i) {
                            $n = $i;
                        } else {
                            $n = $i - 1;
                            $x = $amount - $n * 5000;
                        }
                        break;
                    }
                }

                $amounts = array_fill(0, $n, 5000);
                if (isset($x)) {
                    array_push($amounts, $x);
                }

                $parentcommission = 0;
                foreach ($amounts as $amount) {
                    if ($amount >= 100 && $amount <= 1000) {
                        $provider = Provider::where('recharge1', 'dmt1')->first();
                    } elseif ($amount > 1000 && $amount <= 2000) {
                        $provider = Provider::where('recharge1', 'dmt2')->first();
                    } elseif ($amount > 2000 && $amount <= 3000) {
                        $provider = Provider::where('recharge1', 'dmt3')->first();
                    } elseif ($amount > 3000 && $amount <= 4000) {
                        $provider = Provider::where('recharge1', 'dmt4')->first();
                    } else {
                        $provider = Provider::where('recharge1', 'dmt5')->first();
                    }

                    $parentcommission += \Myhelper::getCommission($amount, $report->user->scheme_id, $provider->id, 'distributor');
                }
            }

            if ($report->product == "dmt" || ($report->product == 'aeps' && $report->option1 == "M")) {
                $insert['amount'] = $precommission - $parentcommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            } elseif (in_array($report->product, ['recharge', 'billpay', 'aeps', 'matm'])) {
                $insert['amount'] = $parentcommission - $precommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            } elseif ($report->product == "utipancard") {
                $insert['amount'] = $report->option1 * $parentcommission - $precommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            }
            if ($insert['amount'] != 0) {
                User::where('id', $parent->id)->increment('mainwallet', $insert['amount'] - $insert['tds']);
                Report::create($insert);
            }

            if (in_array($report->apicode, ['aeps', 'kaeps', 'ifaeps'])) {
                Aepsreport::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            } elseif (in_array($report->apicode, ['microatm', 'fmicroatm'])) {
                Microatmreport::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            } else {
                Report::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            }

            if (in_array($report->product, ['recharge', 'billpay', 'dmt', 'aeps', 'matm', 'aadharpay'])) {
                $precommission = $parentcommission;
            } elseif ($report->product == "utipancard") {
                $precommission = $report->option1 * $parentcommission;
            }

            $parent = User::where('id', $parent->parent_id)->first(['id', 'mainwallet', 'scheme_id', 'role_id', 'parent_id']);
        }

        if ($parent->role->slug == "md") {
            $insert['balance'] = $parent->mainwallet;
            $insert['user_id'] = $parent->id;
            $insert['credit_by'] = $report->user_id;

            if ($report->provider->recharge1 != "payourtransfer") {
                $parentcommission = \Myhelper::getCommission($report->amount, $report->user->scheme_id, $provider, 'md');
            } else {
                $amount = $report->amount;
                for ($i = 1; $i < 6; $i++) {
                    if (5000 * ($i - 1) <= $amount  && $amount <= 5000 * $i) {
                        if ($amount == 5000 * $i) {
                            $n = $i;
                        } else {
                            $n = $i - 1;
                            $x = $amount - $n * 5000;
                        }
                        break;
                    }
                }

                $amounts = array_fill(0, $n, 5000);
                if (isset($x)) {
                    array_push($amounts, $x);
                }

                $parentcommission = 0;
                foreach ($amounts as $amount) {
                    if ($amount >= 100 && $amount <= 1000) {
                        $provider = Provider::where('recharge1', 'dmt1')->first();
                    } elseif ($amount > 1000 && $amount <= 2000) {
                        $provider = Provider::where('recharge1', 'dmt2')->first();
                    } elseif ($amount > 2000 && $amount <= 3000) {
                        $provider = Provider::where('recharge1', 'dmt3')->first();
                    } elseif ($amount > 3000 && $amount <= 4000) {
                        $provider = Provider::where('recharge1', 'dmt4')->first();
                    } else {
                        $provider = Provider::where('recharge1', 'dmt5')->first();
                    }

                    $parentcommission += \Myhelper::getCommission($amount, $report->user->scheme_id, $provider->id, 'md');
                }
            }

            if ($report->product == "dmt" || ($report->product == 'aeps' && $report->option1 == "M")) {
                $insert['amount'] = $precommission - $parentcommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            } elseif (in_array($report->product, ['recharge', 'billpay', 'aeps', 'matm'])) {
                $insert['amount'] = $parentcommission - $precommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            } elseif ($report->product == "utipancard") {
                $insert['amount'] = $report->option1 * $parentcommission - $precommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            }

            if ($insert['amount'] != 0) {
                User::where('id', $parent->id)->increment('mainwallet', $insert['amount'] - $insert['tds']);
                Report::create($insert);
            }

            if (in_array($report->apicode, ['aeps', 'kaeps', 'ifaeps'])) {
                Aepsreport::where('id', $report->id)->update(['mdid' => $parent->id, "mdprofit" => $insert['amount']]);
            } elseif (in_array($report->apicode, ['microatm', 'fmicroatm'])) {
                Microatmreport::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            } else {
                Report::where('id', $report->id)->update(['mdid' => $parent->id, "mdprofit" => $insert['amount']]);
            }

            if (in_array($report->product, ['recharge', 'billpay', 'dmt', 'aeps', 'matm', 'aadharpay'])) {
                $precommission = $parentcommission;
            } elseif ($report->product == "utipancard") {
                $precommission = $report->option1 * $parentcommission;
            }
            $parent = User::where('id', $parent->parent_id)->first(['id', 'mainwallet', 'scheme_id', 'role_id', 'parent_id']);
        }

        if ($parent->role->slug == "whitelable") {
            $insert['balance'] = $parent->mainwallet;
            $insert['user_id'] = $parent->id;
            $insert['credit_by'] = $report->user_id;

            if ($report->provider->recharge1 != "payourtransfer") {
                $parentcommission = \Myhelper::getCommission($report->amount, $report->user->scheme_id, $provider, 'whitelable');
            } else {
                $amount = $report->amount;
                for ($i = 1; $i < 6; $i++) {
                    if (5000 * ($i - 1) <= $amount  && $amount <= 5000 * $i) {
                        if ($amount == 5000 * $i) {
                            $n = $i;
                        } else {
                            $n = $i - 1;
                            $x = $amount - $n * 5000;
                        }
                        break;
                    }
                }

                $amounts = array_fill(0, $n, 5000);
                if (isset($x)) {
                    array_push($amounts, $x);
                }

                $parentcommission = 0;
                foreach ($amounts as $amount) {
                    if ($amount >= 100 && $amount <= 1000) {
                        $provider = Provider::where('recharge1', 'dmt1')->first();
                    } elseif ($amount > 1000 && $amount <= 2000) {
                        $provider = Provider::where('recharge1', 'dmt2')->first();
                    } elseif ($amount > 2000 && $amount <= 3000) {
                        $provider = Provider::where('recharge1', 'dmt3')->first();
                    } elseif ($amount > 3000 && $amount <= 4000) {
                        $provider = Provider::where('recharge1', 'dmt4')->first();
                    } else {
                        $provider = Provider::where('recharge1', 'dmt5')->first();
                    }

                    $parentcommission += \Myhelper::getCommission($amount, $report->user->scheme_id, $provider->id, 'whitelable');
                }
            }

            if ($report->product == "dmt" || ($report->product == 'aeps' && $report->option1 == "M")) {
                $insert['amount'] = $precommission - $parentcommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            } elseif (in_array($report->product, ['recharge', 'billpay', 'aeps', 'matm'])) {
                $insert['amount'] = $parentcommission - $precommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            } elseif ($report->product == "utipancard") {
                $insert['amount'] = $report->option1 * $parentcommission - $precommission;
                $insert['tds'] = round(($insert['amount'] * $api->tds) / 100, 2);
            }

            if ($insert['amount'] != 0) {
                User::where('id', $parent->id)->increment('mainwallet', $insert['amount'] - $insert['tds']);
                Report::create($insert);
            }

            if (in_array($report->apicode, ['aeps', 'kaeps', 'ifaeps'])) {
                Aepsreport::where('id', $report->id)->update(['wid' => $parent->id, "wprofit" => $insert['amount']]);
            } elseif (in_array($report->apicode, ['microatm', 'fmicroatm'])) {
                Microatmreport::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            } else {
                Report::where('id', $report->id)->update(['wid' => $parent->id, "wprofit" => $insert['amount']]);
            }
        }
    }

    public static function getCommission($amount, $scheme, $slab, $role)
    {
        $myscheme = Scheme::where('id', $scheme)->first(['status']);
        if ($myscheme && $myscheme->status == "1") {
            $comdata = Commission::where('scheme_id', $scheme)->where('slab', $slab)->first();
            if ($comdata) {
                if ($comdata->type == "percent") {
                    $commission = $amount * $comdata[$role] / 100;
                } else {
                    $commission = $comdata[$role];
                }
                if ($commission == null) {
                    $commission = 0;
                }
            } else {
                $commission = 0;
            }
        } else {
            $commission = 0;
        }
        return $commission;
    }

    public static function curl($url, $method = 'GET', $parameters, $header, $log = "no", $modal = "none", $txnid = "none")
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_TIMEOUT, 240);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if ($parameters != "") {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        }

        if (sizeof($header) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        try {
            if ($log != "no") {
                switch ($modal) {
                    case 'report':
                        $table = \App\Models\LogReport::query();
                        break;

                    case 'aepsreport':
                        $table = \App\Models\LogAepsreport::query();

                        break;

                    case 'matmreport':
                        $table = \App\Models\LogMicroatmreport::query();
                        break;

                    default:
                        $table = \App\Models\Apilog::query();
                        break;
                }

                if (isset($table)) {
                    $table->create([
                        "url" => $url,
                        "modal" => $modal,
                        "txnid" => $txnid,
                        "header" => $header,
                        "request" => $parameters,
                        "response" => $code . "/" . $err . "/" . $response
                    ]);
                }
            }
        } catch (\Exception $e) {
        }
        return ["response" => $response, "error" => $err, 'code' => $code];
    }

    public static function getParents($id)
    {
        $data = [];
        $user = User::where('id', $id)->first(['id', 'role_id']);
        if ($user) {
            $data[] = $id;
            switch ($user->role->slug) {
                case 'whitelable':
                    $mds = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'retaillite']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;

                case 'md':
                    $distributors = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'retaillite']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;

                case 'distributor':
                    $retailers = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'retaillite']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;

                case 'admin':
                case 'mis':
                case 'STORE':
                    $adminuser = User::where('role_id', '1')->first(['id', 'role_id']);
                    $data[] = $adminuser->id;
                    $whitelabels = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'whitelable');
                    })->get(['id']);

                    if (sizeOf($whitelabels) > 0) {
                        foreach ($whitelabels as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $mds = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = \App\Models\User::whereIntegerInRaw('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'retaillite']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;
            }
        }
        return $data;
    }

    public static function transactionRefund($id, $table, $wallet)
    {
        $report = \DB::table($table)->where('id', $id)->first();
        $count  = \DB::table($table)->where('user_id', $report->user_id)->where('status', 'refunded')->where('txnid', $report->id)->count();

        if ($count == 0) {
            $insert = [
                'number'   => $report->number,
                'mobile'   => $report->mobile,
                'provider_id' => $report->provider_id,
                'api_id'   => $report->api_id,
                'apitxnid' => $report->apitxnid,
                'txnid'    => $report->txnid,
                'payid'    => $report->payid,
                'refno'    => "Refund Against " + $report->id,
                'description' => "Transaction Reversed, amount refunded",
                'remark'  => $report->remark,
                'option1' => $report->option1,
                'option2' => $report->option2,
                'option3' => $report->option3,
                'option4' => $report->option4,
                'option5' => $report->option5,
                'option6' => $report->option6,
                'option7' => $report->option7,
                'option8' => $report->option8,
                'status'  => 'refunded',
                'rtype'   => $report->rtype,
                'via'     => $report->via,
                'trans_type' => ($report->trans_type == "credit") ? "debit" : "credit",
                'product' => $report->product,
                'amount'  => $report->amount,
                'profit'  => $report->profit,
                'charge'  => $report->charge,
                'gst'     => $report->gst,
                'tds'     => $report->tds,
                'balance' => \Myhelper::getAccBalance($report->user_id, $wallet),
                'user_id' => $report->user_id,
                'credit_by'  => $report->credit_by,
                'created_at' => date("Y-m-d H:i:s")
            ];

            try {
                $report = \DB::transaction(function () use ($table, $report, $wallet, $insert) {
                    $debit = $report->balance - $report->closing;

                    if ($debit < 0) {
                        $debit = -1 * $debit;
                    }

                    if ($report->trans_type == "debit") {
                        User::where('id', $report->user_id)->increment($wallet, $debit);
                    } else {
                        User::where('id', $report->user_id)->decrement($wallet, $debit);
                    }

                    $insert["closing"] = \Myhelper::getAccBalance($report->user_id, $wallet);
                    \DB::table($table)->insert($insert);
                });
            } catch (\Exception $e) {
                \DB::table('log_500')->insert([
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'log'  => $e->getMessage(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public static function getTds($amount)
    {
        return $amount * 5 / 100;
    }

    public static function callback($id, $product)
    {
        switch ($product) {
            case 'recharge':
                $report = Report::where('id', $id)->first();
                $callback['product'] = $product;
                $callback['status']  = $report->status;
                $callback['refno']   = $report->refno;
                $callback['txnid']   = $report->apitxnid;
                $query = http_build_query($callback);
                $url = $report->user->callbackurl . "?" . $query;

                $result = \Myhelper::curl($url, "GET", "", [], "no", "", "");
                Callbackresponse::create([
                    'url' => $url,
                    'response' => ($result['response'] != '') ? $result['response'] : $result['error'],
                    'status'   => $result['code'],
                    'product'  => $product,
                    'user_id'  => $report->user_id,
                    'transaction_id' => $report->id
                ]);
                break;
        }
    }

    public static function FormValidator($rules, $post)
    {
        $validator = \Validator::make($post->all(), array_reverse($rules));
        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $key => $value) {
                $error = $value[0];
            }
            return response()->json(array(
                'status'     => 'ERR',
                'statuscode' => 'ERR',
                'message'    => $error
            ));
        } else {
            return "no";
        }
    }

    public static function webValidator($rules, $post)
    {
        $validator = \Validator::make((array)$post, array_reverse($rules));
        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $key => $value) {
                $error = $value[0];
            }
            return response()->json(array(
                'status'     => 'ERR',
                'statuscode' => 'ERR',
                'message'    => $error
            ));
        } else {
            return "no";
        }
    }

    public static  function encrypt($plainText, $key)
    {
        $secretKey  = \Myhelper::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode   = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    public static function decrypt($encryptedText, $key)
    {
        $key = \Myhelper::hextobin(md5($key));
        $initVector    = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = \Myhelper::hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    public static  function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }

    public static function ebankerencrypt($data, $key, $iv)
    {
        // $data = json_encode($data, JSON_UNESCAPED_SLASHES);
        // $ciphertext_raw = openssl_encrypt($data, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);
        // return bin2hex($ciphertext_raw);


        define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: $key);
        define('ENCRYPTION_IV', getenv('ENCRYPTION_IV') ?: $iv);
        define('CIPHER_METHOD', 'aes-256-cbc');


        $key = hex2bin(ENCRYPTION_KEY);
        $iv = hex2bin(ENCRYPTION_IV);
        $encryptedData = openssl_encrypt($data, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);
        return bin2hex($encryptedData);
    }

    public static function ebankerdecrypt($data, $key, $iv)
    {
        // $data = hex2bin($data);
        // return json_decode(openssl_decrypt($data, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv));


        define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: $key);
        define('ENCRYPTION_IV', getenv('ENCRYPTION_IV') ?: $iv);
        define('CIPHER_METHOD', 'aes-256-cbc');

        $key = hex2bin(ENCRYPTION_KEY);
        $iv = hex2bin(ENCRYPTION_IV);
        $encryptedData = hex2bin($data);
        $decryptedData = openssl_decrypt($encryptedData, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);
        return $decryptedData;
    }

    public static function newDecrypt($encryptedData, $key = null, $iv = null)
    {
        $key = $key ?? self::hexToBytes(env('CRYPTO_KEY'));
        $iv = $iv ?? self::hexToBytes(env('IV_KEY'));
        $cipherMethod = "AES-256-CBC";
        $encryptedBytes = self::hexToBytes($encryptedData);
        $decrypted = openssl_decrypt($encryptedBytes, $cipherMethod, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

    public static function newEncrypt($data, $key = null, $iv = null)
    {
        // api_key=596e6fc87495e86afb31437b866cce1e00a1248169a90f0fa8eefc230a0b7af4
        // aes_key=3c8cdd3e3028795dacf67ef25a89509a989768b067a7b591cc468954ad4e1620
        // aes_iv=ec5bad40b2162069
        // client_id=98dfe4dbc68bb6948a85137927f857e0
        $key = $key ?? self::hexToBytes(env('CRYPTO_KEY'));
        $iv = $iv ?? self::hexToBytes(env('IV_KEY'));
        $cipherMethod = "AES-256-CBC";
        $encrypted = openssl_encrypt($data, $cipherMethod, $key, OPENSSL_RAW_DATA, $iv);
        return self::bytesToHex($encrypted);
    }
    private static function hexToBytes($hex)
    {
        return hex2bin($hex);
    }

    private static function bytesToHex($bytes)
    {
        return bin2hex($bytes);
    }
}
