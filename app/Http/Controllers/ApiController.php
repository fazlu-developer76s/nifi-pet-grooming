<?php

namespace App\Http\Controllers;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Models\Kycprocess;
use App\Models\Package;
use App\Models\Page;
use App\Models\Pets;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Global_helper as GlobalHelper;


class ApiController extends Controller
{
    public function get_aadhar_otp(Request $post)
    {

        return response()->json(['status' => 'TXNOTP', 'message' => "Aadhar verify successfully","client_id"=>6783597812]);


        $rules = array(
            'register_aadhar' => 'required'
        );
        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }
        // encrypt
        $user_data = array(
            "p1" => $post->register_aadhar,
            "p2" => rand(0000000000,9999999999)
        );
        $urls = "https://api.nifipayments.com/api/user/encrypt";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "x-api-iv: 58e45c94e3c0707abbe7ae9f12f4fff2",
            "x-api-key: d1ef40c68da4df29e4a28df898c13b636748f6c56d3290027cf5946ca06f794a"
        ];
        $encrypt_data = \Myhelper::curl($urls, "POST", json_encode($user_data), $headers, "yes", "report");
        // encrypt
        $aadharRecord = \DB::table("kycdatas")->where("type", "aadhar")->where('number', $post->register_aadhar)->first();
        if (!$aadharRecord) {
            $url = "https://api.nifipayments.com/api/v1/validate/aadhar/advance";
            $header = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'x-client-id: e26c92f1fb5a0b937a125b4797c8e42d',
                'x-api-key: 9efb1d0446137c4be81c06ddad6de420041000e0acd4baeaf03bfe624d7dbd0e',
            );
            $parameter['body'] = json_decode($encrypt_data['response'])->body;
            $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "report", $post->register_aadhar);

            // decrypt
            $urls1 = "https://api.nifipayments.com/api/user/decryptReq";
            $user_data1 = array(
                "body" => json_decode($result['response'])->body
            );
            $decrypt_data = \Myhelper::curl($urls1, "POST", json_encode($user_data1), $headers, "yes", "report");
            // decrypt

            if ($decrypt_data != "") {
                $response = json_decode($decrypt_data['response'])->body;
                $response1 =json_decode($response);
                if (isset($response1->data->data->otp_sent) && $response1->data->data->otp_sent === true) {
                    return response()->json(['status' => 'TXNOTP', 'message' => "Aadhar verify successfully", "client_id" => $response1->data->transaction_id]);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => isset($response1->message) ? $response1->message : "Please contact your administrator"]);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Please contact your administrator"]);
            }
        }
         else {
            $response = json_decode($aadharRecord->response);
            return response()->json([
                'status'  => 'success',
                'message' => "Aadhar verified successfully",
                "response" => $aadharRecord->response
                // 'message' => "Aadhar re-verified successfully",
                // "profile" => "data:image/png;base64, " . $response->profile_image,
                // "mobile"  => $aadharRecord->mobile,
                // 'state'   => $response->address->state,
                // 'pincode' => $response->zip,
                // 'city'    => $response->address->po,
                // 'address' => $response->address->house . " " . $response->address->street . " " . $response->address->loc
            ]);
        }
    }

    public function checkaadharotp(Request $post)
    {
        return response()->json(['status' => 'success', 'message' => "Aadhar verified successfully" ,"response"=> "{\"client_id\":\"aadhaar_v2_yroDkhCAOkRCbAxjbcjr\",\"full_name\":\"Rajbir Singh\",\"aadhaar_number\":\"XXXXXXXX9175\",\"dob\":\"2002-11-18\",\"gender\":\"M\",\"address\":{\"country\":\"India\",\"dist\":\"Amritsar\",\"state\":\"Punjab\",\"po\":\"Amritsar G.P.O\",\"loc\":\"Block -E, Pyramid City\",\"vtc\":\"Amritsar -I\",\"subdist\":\"Amritsar\",\"street\":\"Sultanwind Link Road\",\"house\":\"2\",\"landmark\":\"Near Golden Gate\"},\"face_status\":false,\"face_score\":-1,\"zip\":\"143001\",\"profile_image\":\"\\/9j\\/4AAQSkZJRgABAgAAAQABAAD\\/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL\\/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL\\/wAARCADIAKADASIAAhEBAxEB\\/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL\\/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6\\/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL\\/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6\\/9oADAMBAAIRAxEAPwD3uikoxVGItFJiikAtFJiloAMUmB6UtJQAbV9BSbF\\/uj8qWii4rITYv90UbF9KXFFO4WQmwf5NGxff86dijFAcq7Ddg9\\/zo2D1NOoouLlQzZ\\/tGjZ\\/tGn0UXDlQzYf7xpdp\\/vfpTqTFFx8qFopMUtIYUtJRQO4UUUUAFMaVFOM5PoKpXt6I2MS5ZuhUf1rNa6foz\\/8ASs51OU1jTubhuUHUqPq2KYbxOzoPzrEErEcIB7k0okfjlawddmqpI2ftRz99D+dKLr1UH6GshZHz1P4GpVkbpnP1qVXYeyRrLcRscZwfepuKyUYmrEcrJwD+FbRrJ7mcqdti9RTEcOOKdWydzLVC0UmKMUw1FopMUtACUUlGKCRaKSigBagu5hDATu257+lTVgapch33OTsBwid2PsP8\\/UVM3ZFwV2VJpw2Qvyr+pqLzVRgGIUnoM4z+HU1A\\/mS9cr6BTj9f8P1qMbFzluh52jgfWuCpM74RLizKemc+y4\\/nUgmyOjfpWeLhSAyEkHuoLfqoIqbzwpGWkzxjkD+dYORpylwTR5wWYH1KkD86mRyRlJAw9jmqQnbdgq+MdSCf5CnLJHKdy4PH3l6kfhzS5hOJeF2Iz+8G0evT\\/61XYp0kX1H6isxGY9CJFzgjPI\\/p6cUghePMlq2COsZ6fl2+o\\/WtITM5RRuRvtIOcg9DVsHIzWPaXImXoVcfeU\\/5\\/WtOA5XFd1KV9DlqKxNRRRWxmFFFFADc0UUVRncM0ZpKKBXIrqTy7dj+FcpdzKJGZzlj8ox1PsPQf8A6zzW5rMwitwM4JrjJ33kljgnIHOBgdh7Due\\/5Y560raHVh431JpbwvkZG30Hf\\/H\\/AOv0NRLM28AjcU9edvH5D\\/x2qxXC8swBBz1BOefqPXA+pNAnVWAVeR0AAO0+uOnqCOD6Zri5ZSdoo77xgrsuB\\/MSMY3dw5Xdj8cMP1qfz5ECoVkYf3yo\\/of6VXjTcF3opAOdrMXIPseOKm2SEfNPIR7qnH\\/jtbLBVJGLxlNCRuVd5clU6lmUx4x6naP51OJmK7nGUJ6nkY+oJ\\/XFQJbESCTzSxHQMigf+OgU\\/bMmGBDnOe\\/5ev6n6VM8FViOOKpyZZjmwy5JDHkbj179fT9PrV2G8GcSEoy9GPB+vuOn9cVkxurHauEkPQE4Dnv9D7jBGeRUoYqgypwpHB+8pPTp\\/Tr29Dzq6dmatJm0xyTKgAmTqB0Yf4H+dadnOsgVh0YVg2kwLohwR\\/yzYdPp9D\\/ntnUtFMVxgfdLBh+P\\/wBeuyi9TjqqyNeikpcV2HMFFJRQFxuaM0lIaoyuLmkzRSU7EORzniabbJGmfl25J9Pr\\/ntXKtPhSzBixOFXP5D8M\\/mTXReK4szxyEHBjwP9rBJI\\/LNcpK7ZyWOc7R2O45yfrw5z64rlrRu7HoYeSULkjuVJB5Y9T\\/h7fz6mnQnnNYWo300LeVbpkgfMRwBWS+palnALKPwrvo4dQiclSu5yuekW5UjGauKAV6CvM7TWtRSRSZCQDzxziuv07U3uYwWGWrbksZcxv7VZccGmMqgdOlZN7qv2VORg1h3HjCSJ8LFuUGlyNi5jqZIlcMAv3uuOPxz2PvT7aUyYgkIMmCFZv416EN+gP1B78crb+MtzDdCV55BFbtvqFtqarLCCkqH50P8AEOnH1BI\\/H2rjxWEvHnW504fE2lyPYuoTBKYudrnK888n+ec59+e9dDaz\\/aBA2QSxGSOmQea5u+J+zmRhuIw2cdTwD9AflNbnh9XeVt5LGPJJxgAnGB+R\\/SuSgr6nXWelzoqWkorqOO4uaKSigLkW6mlqSkrSxyOTF3UhakpDVWM3JmJ4pj36asgBJifPHpj\\/APVXExDdI2cNsGMkck8c\\/mp\\/OvQtWiM2mXCDrsz+XNcHZRb4Gc43EkfqankvNHXSqfuWjC1GVEPzMEGeTWe2p21mVzaOyv8AddhjP510N7pYnJOAT7is\\/wDsMugR9hUHIDDOPwrsVupCvbQpQzw3LRusTRebnZkYDY9K6Pw+wMhUoTg9qp\\/2cIogCc7RgcYxW5oVt5OcLwaT8iku4zWI1dwqoMkd65Ga9tYJsyJuQNjIXPNeh6jZido2IxxXMX\\/hvcphVV8vOdpGBn2xTj5kvyILW+sLqPZbuhl7LIm0n6YA\\/rWzpex2yV2uOKyovD7tEluYdsanOAOc+uetdNpmlG2VdxLY7t1ola2hFxly+2wlfgqYWbn\\/AHSB+iiun8NQhNN83BzKQefYAVzdxal4bi3Ax8hUAdAMMBXa2Nv9lsYYSMFEAOPXvXmwjypo9CrO8UWc0ZpMUVZzi5ozRSUDK+aTNFJWpwthmgtSGmmmRcbJhlII4IxXn2BaXk9v2QnH\\/fTV6A1cZ4itPJ1ZbkH5ZY9uPQj\\/APXWtNXZcJ20K\\/mgjpTCgJyBiq6sc8ZqdDn\\/AOvVtHQiCY7pBGCABya19MkhDj5xwOfeua1dpYkMkJOTwaytOu7+IN5krSHscYIp2uimeqO1vPBsMiiQfdqkwD\\/KwGRXHRXGqzXMTROhj7gjkV11sH8kM5yx60mrEXJoFWPtVsTLt4GKpeZt9\\/ahXyaViZF3SIlu72aZxlUYYB9QTiujBrI0OExaerMMNIdxrWFcslqzVTuOzRmkpagsM0ZoooArZpCaQ0hrY89sC1NLUEUhBpk3Gs1cx4pk2xw9Mbua6crWJrtiLu0fB+cDitqVrivY5ASgVQvtUltThI92f0p7uUYoTyDiq1wizHrirkrM7Iu6ImvXnhzO4QE5xmrVrd6f5ZSVWyejDFZraZErbgu9epBPSrUdppjAbolBH+2Rn9aLm0YJrU00u7MFBCTEQRjcetXE8S\\/Z5hbzKSOgZayk0yzuQFiiAz\\/FuJx+tXI9FhgClZC5H985odupnOKT0N9LjzRuHKmrEDeZKqHjccVnq4RABxgVo6PF9pvQedq\\/MTSXcxm7I6xMBQB0FSBqjAxThXIwi2iUNS5pgpwqGdCbHZpM0UUiiqTTSaKStzzrhSE4oNNNAhGaqdzhlIq2elVZhnNawEzzbxUV0\\/UVdBhHGW+tZ8E8dwMqwqz47cS3gRQR5YwSe9cZb3stnJ8pJTPNay1OqltqdotpvGGcYNMGhRtOGM547GufXWyed\\/Xpg1Zj8SFU5bJHAJqUmjVs7K00uNIwY5Ax9c1YeHy8M7cL0riIfE8glBBAX2NLe+JpZoPKjOWPU0+Vsls6G81ZFnEERDSHgDNdv4fjKW0R4JKgsQfWvJNER5LvfISTjg1694elt5rT9zIpZPldAclSOOac7KDOeomzdBpwNMFPArjY4tjwaeDUYp4FQzoi2LmjNFFIu7KeaaXpuaax5roSPOFL00vTGYDvxVJ9TtFuBB5ymVhkKvNWogk2XTJVS8n8m3kk4yBxmql5qqW0W9iiDOMue9YlzfT3MMgd9yvGSAMAAA88f561pGPUuMGzlfE80lzLHcMAYWGzpyO4yffmuQmgyxIziu4udstpLC0YfzflUn+E+tcpLFJBK0Mq4ZTg+9Jtnba2iMCWJgTzwOlM2SEdeP51sNArnkU9bTAHFK4GbFDJuweua1LezkGMIeTxV6104M29xnPat63tUEYXHAo5yGO0u1S3i8x1BwPTmofC\\/iR7HXLgrysspLDPVcnj9asXc4gtn28cVxNm5jumYHo+a0h710yHtc+kIJ0niSRGBVhkEVODWJ4dure40uIW5XagAwK2xXJNWdjNXTHg07NMFPrNm0Wxc0ZpKXFIvU5+fVbeGQxlw0gGdo7Vg6r4olt4IjDGoaZsLznj1qKwtUDspy78kkHnpRqdnbR6hZxyABUhZsucDPAruSijn9nFNIoya5NdELICTns2Afwp8rsoMkWI2iYAPnJJNT2mlRSXRkUnYuWyvIpNRittO0\\/fcS4YgykMepPTikjaTjeyOSv7yWaGVi7M01yNufRQf8RWxdySaamm3TIwt9vly\\/Ru\\/wCYzWa19YmOwQOc5aQgR8jJx6f7Na\\/iG986xjgFk7IUX5mbB4B7fjW0rpERd9EjN1Yst7uh\\/wCPZBwR0JNZRtRqCgAf6YxzuJ4x2H\\/16v2tyLq0GnFgsh+4x7r6U7To1tJ5JvvFGIUN1OO5rNrqaXuuV9Dnbi1ntLhoZ4milQ4KsMEVNC6jAwK6u7D+JrVpoxDLJb\\/KWJxIR6Y9PT\\/9dcvLD5TgEEEGoaEn3L8LYGBV3zdie9ZkLgMB61emBVBSAz9RuWaNue1c7E2Jz6k1s6iMAD+9WYsQWYNxWlJ6ky2PXfAyzJo6THiNzge3bNdYbw24JmGUH8S1xvhC7u49IOSGgQKPLBB2+9dDqDB7Jpod3yjcVH8Q7is5xvLUnmurm5BPHcRLJG25W6Gpc1zFpr1j5Ue3ciADbt5H41fTVCCDuVkPTNZODuUk7GxupQ1VYbuKbvtPoas1m1YE2eRaPbAtNJE8kZCHlTU2sM512zS4labMTABu3P8A9arOh3GnfZJW3uCVA7d6o69dWo8S2pikMmyL7vvk8V1LmsVJxdQ07a0K285gkli34QBGwDk1m+I1WONwCztlUDMcmt+zvoDFB5lrIjMTIMDrgVy+vapLIiBLTbukyCw5pRT0TE2nJtIhFuzazDEqH93FGoAH+yP6k1ua9DKZlURtgEjp7CsezvdRufEshBRcTBcH2OP6Va8RSakZxmdR87dCfQD+lXJLuOm5XRjz2T29yt1sKgdSeBVi4lS6jSK0fJRR5so4BPUgetMsZdRS6C+cj+oboa1LiJxqUkckCW\\/mAFSB8pfHr71F9NDSXxK5DDbKpF3HNNC+fLJgUE8juO4p97bm7toxLboJYwQZUGBIM8H69f8AIqaK2eC5iklJjhIOVOQCfTNTXdwjOI4tpXGTt6D2oTajZmUkpTujl44GN8sYB4Nak0Dbs44FTW9sEuDK3U+9WJ57eCMtK6KPc1JRyWpgtJu6Bayg+6QVv69CI4YmUOpc854FZVrarlXc\\/LnjP8R9K3paK5E+x6L4a1HTU0\\/7E0qpdeWvXglvSur0wGSNo3wCV6djXiLQyC4aUMwYtnI9c16V4Z1qZ4IQziSYYQqR973qJ+Q+VqNyO90+XTrye2Iyg+eMgfwntVzRHme2dZIzIifOoPb1xS6xq1uuqATO0L\\/Zh8hGRnJ6VHpOs2UcgBMwDAjOOKl81wU7wH6he3ukM7QEFR8yq4yCKu2fiO4U28kyFoZkzlR36EYqDUNW0+40uJmnBYAody8\\/yrDstZtF0xkdpFMEwwWXIwQf\\/iauEeZNNGVSWiZU0m8tDYKHUAvIMgr2HNY15dQy+JppIlDbAFQAd8f\\/AK6KKOW0TTmvUOuivL6Pb\\/oZ\\/dW+fu+v\\/wCquWvp725vbOFrbG6QdQRnkUUU0lzLQzU5WYzR5byXXmk3RJulLHLrx1PrVnW5byS4GbqD+I\\/fX+8aKKuSRUJPmRmW73sd4m2WJyTjh1NdJr11dtpN4Z7ZkKY2uARg0UVEUrjrTkmhNMY3+kwXLTMUV1YrjJGeCKoeJZx4dm32yhlkb+P3Gf8AGiism3sbRiuc5O58U3k2cTBB6IMfrUuh3K3V8bm6ZpNv+rDnI3difpRRTN3a2hoah51xN5107BRnLEfoKfa\\/2fJfxxMXVUCjr3xz+uaKK0j8Jyz+I3Z9KspIkME4yc9T7mtPw9YTRXkZABCkdDmiioktwUmokvidtmrWLnGHQrz7f\\/rp8BWN4+MDOKKKynujSnrEiugj2GzaNyTsOnbmsW5byrS\\/UfwvG3T1z\\/jRRVx0kQ\\/hP\\/\\/Z\",\"has_image\":true,\"email_hash\":\"\",\"mobile_hash\":\"4affeb96c4cf60640088712d3f3b7d64dcfccf8dbb06b425098cce2735b2fafe\",\"raw_xml\":\"https:\\/\\/aadhaar-kyc-docs.s3.amazonaws.com\\/nerasoft\\/aadhaar_xml\\/917520250227182422214\\/917520250227182422214-2025-02-27-125422440640.xml?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAY5K3QRM5FYWPQJEB%2F20250227%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Date=20250227T125422Z&X-Amz-Expires=432000&X-Amz-SignedHeaders=host&X-Amz-Signature=0fd24fbdabf9d6e80c34d57fe2738be0d2625b028d35be9a5b9ec989a64c3ab2\",\"zip_data\":\"https:\\/\\/aadhaar-kyc-docs.s3.amazonaws.com\\/nerasoft\\/aadhaar_xml\\/917520250227182422214\\/917520250227182422214-2025-02-27-125422354598.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAY5K3QRM5FYWPQJEB%2F20250227%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Date=20250227T125422Z&X-Amz-Expires=432000&X-Amz-SignedHeaders=host&X-Amz-Signature=d7249f834ab4e83a37753034960571ab83509359b541fd67757a19af8df6313a\",\"care_of\":\"C\\/O: Surinder Singh\",\"share_code\":\"5491\",\"mobile_verified\":false,\"reference_id\":\"917520250227182422214\",\"aadhaar_pdf\":null,\"status\":\"success_aadhaar\",\"uniqueness_id\":\"06d6559db4ddd65ae8d23842f4603ffb574ab3bf8a7cc94cc891b975a75f5044\"}"]);

        $rules = array(
            'otp'       => 'required',
            'client_id' => "required",
            // 'mobile'    => "required"
        );
        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }

        // encrypt
        $user_data = array(
        "p1" => $post->client_id,
        "p2" => $post->otp
        );
        $urls = "https://api.nifipayments.com/api/user/encrypt";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "x-api-iv: 58e45c94e3c0707abbe7ae9f12f4fff2",
            "x-api-key: d1ef40c68da4df29e4a28df898c13b636748f6c56d3290027cf5946ca06f794a"
        ];
        $encrypt_data = \Myhelper::curl($urls, "POST", json_encode($user_data), $headers, "yes", "report");

        // encrypt
        $url = "https://api.nifipayments.com/api/v1/validate/otp-submit/advance";
        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'x-client-id: e26c92f1fb5a0b937a125b4797c8e42d',
            'x-api-key: 9efb1d0446137c4be81c06ddad6de420041000e0acd4baeaf03bfe624d7dbd0e',
        );

        $parameter['body'] = json_decode($encrypt_data['response'])->body;
        $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "report");

        // decrypt
        $urls1 = "https://api.nifipayments.com/api/user/decryptReq";
        $user_data1 = array(
            "body" => json_decode($result['response'])->body
        );
        $decrypt_data = \Myhelper::curl($urls1, "POST", json_encode($user_data1), $headers, "yes", "report");
        // decrypt
        if ($decrypt_data != "") {
            $response = json_decode($decrypt_data['response'])->body;
            $response1 =json_decode($response);
            if (isset($response1->status) && $response1->status === 'success') {

                \DB::table("kycdatas")->insert([
                    "type"   => "aadhar",
                    "name"   => $response1->data->full_name,
                    "number" => $response1->data->aadhaar_number,
                    "mobile" => $post->mobile,
                    "state"  => $post->client_id,
                    "response" => json_encode($response1->data),
                    'user_id' => \Auth::id()
                ]);
                return response()->json([
                    'status'  => 'success',
                    'message' => "Aadhar verified successfully",
                    // "profile" => "data:image/png;base64, " . $response1->data->profile_image,
                    // "mobile"  => $post->mobile,
                    // "number" => $response1->data->aadhaar_number,
                    // "name"   => $response1->data->full_name,
                    // 'state'   => $response1->data->address->state,
                    // 'pincode' => $response1->data->zip,
                    // 'city'    => $response1->data->address->po,
                    // 'address' => $response1->data->address->house . " " . $response1->data->address->street . " " . $response1->data->address->landmark . " " . $response1->data->address->loc,
                    "response" => json_encode($response1->data)
                ]);
            } else {
                return response()->json(['status' => 'ERR', 'message' => isset($response1->message) ? $response1->message : "Please contact your administrator"]);
            }
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Please contact your administrator"]);
        }
    }

    public function update_profile(Request $request)
    {
        $user = $request->user;
        $rules = array(
            'name'       => 'required',
            'email' => "required",
            'mobile'    => "required",
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        //     'mobile' => 'required|digits:10',
        //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        // ]);




        $exists = User::where(function ($query) use ($request, $user) {
            $query->where('email', $request->email)
                ->orWhere('mobile_no', $request->mobile);
        })
            ->where('id', '!=', $user->id)
            ->where('status', '!=', 3)
            ->exists();
        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or Mobile already exists'
            ], 422);
        }
        $user = User::find($request->user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->t_shirt_size = $request->t_shirt_size;
        $user->mobile_no = $request->mobile;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_images'), $imageName);
            $user->image = 'uploads/profile_images/' . $imageName;
        }
        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile_no,
                    't_shirt_size' => $user->t_shirt_size,
                    'image' => $user->image // Return full image URL
                ]
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Profile update failed. Please try again.'
        ], 500);
    }

    public function add_helper(Request $request){

        $user = $request->user;
        $rules = array(
            'name'       => 'required',
            'age' => "required",
            'mobile'    => "required",
            'dob'    => "required",
            'gender'    => "required",
            'address'    => "required",
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $check_helper = DB::table('tbl_helpers')->where('mobile',$request->mobile)->first();
        if($check_helper){
            return response()->json([
                'status'=>'error',
                'message'=>'helper already exists.'
            ]);
        }
        $image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/helper'), $imageName);
            $image = 'uploads/helper/' . $imageName;
        }
        DB::table('tbl_helpers')->insert(['user_id'=>$request->user->id,'name'=>$request->name,'dob'=>$request->dob,'age'=>$request->age,'mobile'=>$request->mobile,'gender'=>$request->gender,'address'=>$request->address,'image'=>$image]);
        return response()->json([
            'status' => 'success',
            'message' => 'helper add successfully',
        ], 200);
    }

    public function get_helper(Request $request){
        $get_helper = DB::table('tbl_helpers')->where('user_id',$request->user->id)->where('status',1)->get();
        return response()->json([
            'status'=>'success',
            'message' =>'helper fetched successfully',
            'data' => $get_helper
        ]);
    }

    public function delete_helper(Request $request ,$id){
      $delete_helper = DB::table('tbl_helpers')->where('id',$id)->delete();
      if($delete_helper){
        return response()->json([
            'status' => 'success',
            'message' => 'helper deleted successfully',
        ], 200);
      }else{
        return response()->json([
            'status' => 'error',
            'message' => 'helper not deleted!',
        ], 200);
      }
    }


    public function user_profile(Request $request)
    {
        $user_id = $request->user->id;
        $user_details = User::where('id', $user_id)
            ->first();
        $role_details = DB::table('roles')
            ->where('id', $request->user->role_id)
            ->where('status', 1)
            ->first();
        if ($user_details) {
            return response()->json([
                'status' => 'success',
                'message' => 'User profile',
                'data' => $user_details,
                'role' => $role_details->title,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 401);
        }
    }

    public function get_kyc(Request $request){
        $user_id = $request->user->id;
        $kyc_details = Kycprocess::where('user_id', $user_id)->first();
        // $kyc_details = DB::table('kycdatas')->where('user_id', $user_id)->first();
        if ($kyc_details) {
            return response()->json([
               'status' =>'success',
               'message' => 'KYC details',
                'data' => $kyc_details
            ], 200);
        } else {
            return response()->json([
               'status' => 'error',
               'message' => 'KYC details not found'
            ], 401);
        }
    }



    public function update_kyc(Request $request)
    {

        $user = $request->user;
        $user_id = $user->id;
        $user_update = Kycprocess::where('user_id', $user_id)->first();
        if (!$user_update) {
            $user_update = new Kycprocess();
            $user_update->kyc_status = 1;
            $user_update->user_id = $user_id;
        }
        if ($request->name) {
            $user_update->name = $request->name;
        }

        if ($request->mobile_no) {
            $user_update->mobile_no = $request->mobile_no;
        }

        if ($request->email) {
            $user_update->email = $request->email;
        }

        if ($request->date_of_birth) {
            $user_update->date_of_birth = $request->date_of_birth;
        }

        if ($request->gender) {
            $user_update->gender = $request->gender;
        }

        if ($request->is_personal_verified) {
            $user_update->is_personal_verified = $request->is_personal_verified;
        }


        if ($request->aadhar_no) {
            $user_update->aadhar_no = $request->aadhar_no;
        }
        if ($request->aadhar_name) {
            $user_update->aadhar_name = $request->aadhar_name;
        }
        if ($request->aadhar_father_name) {
            $user_update->aadhar_father_name = $request->aadhar_father_name;
        }
        if ($request->aadhar_dob) {
            $user_update->aadhar_dob = $request->aadhar_dob;
        }
        if ($request->aadhar_zipcode) {
            $user_update->aadhar_zipcode = $request->aadhar_zipcode;
        }
        if ($request->aadhar_country) {
            $user_update->aadhar_country = $request->aadhar_country;
        }
        if ($request->aadhar_state) {
            $user_update->aadhar_state = $request->aadhar_state;
        }
        if ($request->aadhar_city) {
            $user_update->aadhar_city = $request->aadhar_city;
        }
        if ($request->aadhar_address) {
            $user_update->aadhar_address = $request->aadhar_address;
        }
        if ($request->aadhar_profile_photo) {
            $user_update->aadhar_profile_photo = $request->aadhar_profile_photo;
        }
        if ($request->aadhar_mobile_no) {
            $user_update->aadhar_mobile_no = $request->aadhar_mobile_no;
        }
        if ($request->is_aadhar_verified) {
            $user_update->is_aadhar_verified = $request->is_aadhar_verified;
        }
        if ($request->pan_no) {
            $user_update->pan_no = $request->pan_no;
        }
        if ($request->pan_name) {
            $user_update->pan_name = $request->pan_name;
        }
        if ($request->is_pan_verified) {
            $user_update->is_pan_verified = $request->is_pan_verified;
        }
        if ($request->ifsc_code) {
            $user_update->ifsc_code = $request->ifsc_code;
        }
        if ($request->account_no) {
            $user_update->account_no = $request->account_no;
        }
        if ($request->bank_name) {
            $user_update->bank_name = $request->bank_name;
        }
        if ($request->account_holder_name) {
            $user_update->account_holder_name = $request->account_holder_name;
        }
        if ($request->is_bank_verified) {
            $user_update->is_bank_verified = $request->is_bank_verified;
        }


        if (!empty($request->lat) && !empty($request->long)) {
            $apiKey = '9d52cf15543e4b1d9517f51ba60e6961';
            $url = "https://api.opencagedata.com/geocode/v1/json?q={$request->lat}+{$request->long}&key={$apiKey}";
            $response = file_get_contents($url);
            $responseData = json_decode($response, true);

            if (!empty($responseData['results'])) {
                $addressComponents = $responseData['results'][0]['components'];
                $user_update->normalized_city = $addressComponents['city'] ?? null;
                $user_update->category = $addressComponents['_category'] ?? 'road';
                $user_update->type = $addressComponents['_type'] ?? 'road';
                $user_update->continent = $addressComponents['continent'] ?? null;
                $user_update->country = $addressComponents['country'] ?? null;
                $user_update->country_code = $addressComponents['country_code'] ?? null;
                $user_update->county = $addressComponents['county'] ?? null;
                $user_update->postcode = $addressComponents['postcode'] ?? null;
                $user_update->road = $addressComponents['road'] ?? 'unnamed road';
                $user_update->road_type = $addressComponents['road_type'] ?? 'residential';
                $user_update->state = $addressComponents['state'] ?? null;
                $user_update->state_code = $addressComponents['state_code'] ?? null;
                $user_update->state_district = $addressComponents['state_district'] ?? null;
                $user_update->suburb = $addressComponents['suburb'] ?? null;
            }
        }
        if ($request->is_current_location_verified) {
            $user_update->is_current_location_verified = $request->is_current_location_verified;
        }

        // if ($request->hasFile('equipment_image')) {
        //     $file = $request->file('equipment_image');
        //     $filePath = $file->store('kyc', 'public');
        //     $user_update->equipment_image = $filePath;
        // }
        
        if ($request->hasFile('equipment_image')) {
    $filePaths = [];

    foreach ($request->file('equipment_image') as $file) {
        $filePaths[] = $file->store('kyc', 'public');
    }

    // Store file paths as JSON or an array depending on your database structure
    $user_update->equipment_image = json_encode($filePaths); 
}
        
        
        
        
        
        if ($request->is_equipment_verified) {
            $user_update->is_equipment_verified = $request->is_equipment_verified;
        }

        if ($request->hasFile('live_photo')) {
            $file = $request->file('live_photo');
            $filePath = $file->store('kyc', 'public');
            $user_update->live_photo = $filePath;
        }
        if ($request->is_live_photo_verified) {
            $user_update->is_live_photo_verified = $request->is_live_photo_verified;
        }
        if ($request->hasFile('live_video')) {
            $file = $request->file('live_video');
            $filePath = $file->store('kyc', 'public');
            $user_update->live_video = $filePath;
        }
        if ($request->is_live_video_verified) {
            $user_update->is_live_video_verified = $request->is_live_video_verified;
        }
        if ($request->step) {
            $user_update->step = $request->step;
        }
        if($request->kyc_status){
            $user_update->kyc_status = $request->kyc_status;
        }
        $user_update->save();
        return response()->json(['status' => 'OK', 'message' => "KYC updated successfully"]);
    }


    public function get_services()
    {
        $get_service = Service::where('status', 1)->get();
        if ($get_service) {
            return response()->json(['status' => 'Success', 'message' => 'Services fetched successfully', 'data' => $get_service]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No services found']);
        }
    }

    public function get_packages()
    {
        $get_package = Package::where('status', 1)->orderBy('id', 'desc')->get();
        $add_package_service = array();
        if (!empty($get_package)) {
            foreach ($get_package as $pack) {
                $pack->service = DB::table('add_package_service as a')->leftJoin('services as b', 'b.id', '=', 'a.service_id')->select('a.package_id', 'a.service_id', 'b.*')->where('a.status', 1)->where('b.status', 1)->where('a.package_id', $pack->id)->get();
                $pack->images = DB::table('packages_image')->where('status', 1)->where('package_id', $pack->id)->get();
                $add_package_service[] = $pack;
            }
        }

        if ($add_package_service) {
            return response()->json(['status' => 'Success', 'message' => 'Packages fetched successfully', 'data' => $add_package_service]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No packages found']);
        }
    }

    public function create_pet(Request $request)
    {
        // Define validation rules
        $rules = [
            'pet_name'   => 'required',
            'pet_image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender'     => 'required|string|max:255',
            'pet_type'   => 'required|string|max:255',
            'breed'      => 'required|string|max:255',
            'weight'     => 'required|integer',
            'age'         => 'required',
            'aggression' => 'required|string|max:255',
            'vaccinated' => 'required|string',
        ];

        // Validate the request data
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }

        // Check for existing data
        $check_data = $this->check_exist_data($request, null);
        if ($check_data) {
            $message = '';
            if ($check_data->pet_name == $request->pet_name) {
                $message .= "Pet Category ";
            }
            if ($message) {
                return response()->json(['status' => 'Error', 'message' => $message . 'already exists.']);
            }
        }

        // Create a new Pets instance
        $pet = new Pets();
        $pet->user_id = $request->user->id;

        // Handle the pet image upload
        if ($request->hasFile('pet_image')) {
            $file = $request->file('pet_image');
            $filePath = $file->store('pet_category', 'public');
            $pet->image = $filePath;
        }

        // Assign additional fields
        $pet->gender = $request->gender;
        $pet->pet_name = $request->pet_name;
        $pet->pet_type = $request->pet_type;
        $pet->breed = $request->breed;
        $pet->weight = $request->weight;
        $pet->age = $request->age;
        $pet->aggression = $request->aggression;
        $pet->vaccinated = $request->vaccinated;

        // Save the new pet category
        $pet->save();

        return response()->json(['status' => 'OK', 'message' => "Pet added successfully"]);
    }


    public function list_pet(Request $request)
    {
        $get_pet = Pets::where('user_id', $request->user->id)->where('status', 1)->get();
        if ($get_pet) {
            return response()->json(['status' => 'Success', 'message' => 'Pet List Successfully', 'data' => $get_pet]);
        }
    }
    public function update_pet(Request $request, $id)
    {
        if (!$id) {
            return response()->json(['status' => 'Error', 'message' => 'Pet ID is required']);
        }
        if ($request->method() == "GET") {
            if (!empty($id)) {
                $get_single_pet = Pets::where('id', $id)->where('status', 1)->get();
                if ($get_single_pet) {
                    return response()->json(['status' => 'Success', 'message' => 'Single Pet Fetch Successfully', 'data' => $get_single_pet]);
                }
            }
        }

        if ($request->method() == "POST") {
            // Define validation rules
            $rules = [
                'pet_name'   => 'required',
                'pet_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gender'     => 'required|string|max:255',
                'pet_type'   => 'required|string|max:255',
                'breed'      => 'required|string|max:255',
                'weight'     => 'required|integer',
                'age'         => 'required|integer',
                'aggression' => 'required|string|max:255',
                'vaccinated' => 'required|string',
            ];

            // Validate the request data
            $validate = \Myhelper::FormValidator($rules, $request);
            if ($validate != "no") {
                return $validate;
            }

            // Check for existing data
            $check_data = $this->check_exist_data($request, $id);
            if ($check_data) {
                $message = '';
                if ($check_data->pet_name == $request->pet_name) {
                    $message .= "Pet Category ";
                }
                if ($message) {
                    return response()->json(['status' => 'ERR', 'message' => "Pet Category Already Exists"]);
                }
            }

            // Find the pet category by ID
            $pet = Pets::findOrFail($id);

            // Update the pet category details
            $pet->pet_name = $request->pet_name;
            $pet->user_id = $request->user->id;

            // Handle the pet image upload
            if ($request->hasFile('pet_image')) {
                $file = $request->file('pet_image');
                $filePath = $file->store('pet_category', 'public');
                $pet->image = $filePath;
            }

            // Assign additional fields
            $pet->gender = $request->gender;
            $pet->pet_type = $request->pet_type;
            $pet->breed = $request->breed;
            $pet->weight = $request->weight;
            $pet->age = $request->age;
            $pet->aggression = $request->aggression;
            $pet->vaccinated = $request->vaccinated;

            // Save the updated pet category
            $pet->save();

            return response()->json(['status' => 'OK', 'message' => "Pet Updated Successfully"]);
        }
    }

    public function create_booking(Request $request)
    {
        $rules = array(
            'cart_id'       => 'required',
            'address_id'       => 'required',
            'booking_date'       => 'required',
            'booking_time'       => 'required',

        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        if(!empty($request->cart_id)){
            for($i=0; count($request->cart_id)>$i; $i++){
            $cart_id = '';
            $cart_id = $request->cart_id[$i];
            $address_id = $request->address_id;
            $booking_date = $request->booking_date;
            $booking_time = $request->booking_time;
            $description  = $request->description;
            $booking_amount  = $request->booking_amount;
            $tax_amount  = $request->tax_amount;
            $total_amount  = $request->total_amount;
            $get_cart = DB::table('tbl_cart')->where('id',$cart_id)->where('status',1)->first();
            if(!$get_cart){
                return response()->json(['status' => 'Error', 'message' => 'Cart Service Not Found']);

            }
            $get_service = DB::table('packages')->where('id',$get_cart->service_id)->where('status',1)->first();
            if(!$get_service){
                return response()->json(['status' => 'Error', 'message' => ' Service Not Found']);

            }
            $get_booking_amount  = $get_cart->charge;
            $get_tax  = $get_service->tax;
            $get_tax_amount = $get_service->$get_booking_amount * ($get_tax / 100);
            $get_final_tax_amount  = number_format($get_tax_amount);
            $get_address  = DB::table('tbl_address')->where('status', 1)->where('id', $address_id)->where('user_id', $request->user->id)->first();
            if(!$get_address){
                return response()->json(['status' => 'Error', 'message' => ' Address Not Found']);

            }
            // $insert_booking_id = '';
            $insert_booking_id = DB::table('tbl_pet_bookings')->insertGetId([
                'cart_id' => $cart_id,
                'package_id' => $get_cart->service_id,
                'package_name' => $get_service->title,
                'booking_date' => $booking_date,
                'booking_time' => $booking_time,
                'booking_amount' => $get_service->$get_booking_amount,
                'tax_amount' => $get_final_tax_amount,
                'total_amount' => $get_service->$get_booking_amount + $get_final_tax_amount,
                'description' => $description,
                'customer_id' => $request->user->id,
                'flat_house_no' => $get_address->flat_house_no,
                'area_sector_locality' => $get_address->area_sector_locality,
                'city_district' => $get_address->city_district,
                'state' => $get_address->state,
                'pincode' => $get_address->pincode,
                'complete_address' => $get_address->complete_address,
                'email_address' => $get_address->email_address
            ]);
            $remove_cart = DB::table('tbl_cart')->where('id',$cart_id)->update(['status'=>3]);
            GlobalHelper::SaveNotification($insert_booking_id,$request->user->id,1,'buy package');
        }
        }

        if ($insert_booking_id) {
            return response()->json(['status' => 'OK', 'message' => 'Booking created successfully']);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to create booking']);
        }
    }

    public function cancel_booking(Request $request , $id){

        $insert_cancel = DB::table('tbl_booking_log')->insert(['user_id'=>$request->user->id,'booking_id'=>$id,'type'=>1]);
        if($insert_cancel){
            return response()->json(['status' => 'OK', 'message' => 'Booking cancel successfully'], 200);
        }else{
            return response()->json(['status' => 'Error', 'message' => 'Error']);
        }
    }

   public function my_booking(Request $request){
        $get_array = DB::table('tbl_pet_bookings as a')->leftJoin('users as b','a.accept_user_id','=','b.id')->select('a.*','b.name as user_name','b.mobile_no as user_mobile','b.image as user_profile_img')->where('a.customer_id',$request->user->id)->where('a.status', 1)->orderBy('a.id', 'desc')->get();

        if(!empty($get_array)){
            $get_book = [];
            foreach($get_array as $book ){
               $note_data = DB::table('tbl_notification')->where('booking_id',$book->id)->where('status',1)->get();
               $new_arr = [];
               foreach($note_data as $note){
                $note->user = DB::table('users')->select('name','email','mobile_no')->where('id',$note->user_id)->where('status',1)->first();
                $note->package_info = DB::table('packages')->where('id',$book->package_id)->where('status',1)->first();

                $new_arr[] = $note;
               }
               $book->notification = $new_arr;
               $get_book[] = $book;
            }
        }
        return response()->json(['status' => 'OK', 'message' => 'Booking fetched successfully', 'data' => $get_book], 200);
    }

    public function my_booking_groomer(Request $request){
        $get_array = DB::table('tbl_pet_bookings as a')->leftJoin('users as b','a.customer_id','=','b.id')->select('a.*','b.name as user_name','b.mobile_no as user_mobile','b.image as user_profile_img')->where('a.accept_user_id',$request->user->id)->where('a.status', 1)->orderBy('a.id', 'desc')->get();

        if(!empty($get_array)){
            $get_book = [];
            foreach($get_array as $book ){
               $note_data = DB::table('tbl_notification')->where('booking_id',$book->id)->where('status',1)->get();
               $new_arr = [];
               foreach($note_data as $note){
                $note->user = DB::table('users')->select('name','email','mobile_no')->where('id',$note->user_id)->where('status',1)->first();
                $note->package_info = DB::table('packages')->where('id',$book->package_id)->where('status',1)->first();
                $new_arr[] = $note;
               }
               $book->notification = $new_arr;
               $get_book[] = $book;
            }
        }
        return response()->json(['status' => 'OK', 'message' => 'Booking fetched successfully', 'data' => $get_book], 200);
    }

    public function fetch_booking(Request $request)
    {
        $get_booking_log = DB::table('tbl_booking_log')->where('user_id', $request->user->id)->where('type',1)->get();
        $booking_id = '';
        foreach ($get_booking_log as $log) {
            $booking_id .= $log->booking_id . ',';
        }
        $string = rtrim($booking_id, ',');
        $booking_ids = explode(',', $string);
        $book = DB::table('tbl_pet_bookings as a')
            ->where('a.status', 1)
            ->whereIn('a.booking_status', [1, 3])
            ->whereNotIn('a.id', $booking_ids)
            ->orderBy('a.id', 'desc')
            ->get();
        if ($book->isNotEmpty()) {
            return response()->json(['status' => 'OK', 'message' => 'Booking fetched successfully', 'data' => $book]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No booking found']);
        }
    }


    public function fetch_pet_category(Request $request)
    {

        $fetch_pet_category = DB::table('pet_category')->where('status', 1)->orderBy('id', 'desc')->get();
        if (!empty($fetch_pet_category)) {

            return response()->json(['status' => 'OK', 'message' => ' fetched Pet Category successfully', 'data' => $fetch_pet_category]);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'No booking found']);
        }
    }

    public function accept_booking(Request $request)
    {

        $rules = array(
            'id'       => 'required',
            'booking_status'       => 'required'
        );
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        if ($request->user->role_id != 5) {
            DB::table('tbl_pet_bookings')
                ->where('id', $request->id)
                ->update(['accept_user_id' => $request->user->id,'booking_status'=>$request->booking_status]);
            $insert_cancel = DB::table('tbl_booking_log')->insert(['user_id'=>$request->user->id,'booking_id'=>$request->id,'type'=>2]);
            $subject = '';
            if($request->booking_status == 2){
                $subject = 'accept booking';
            }
            if($request->booking_status == 3){
                $subject = 'cancel booking';
            }
            if($request->booking_status == 4){
                $subject = 'complete booking';
            }
            GlobalHelper::SaveNotification($request->id,$request->user->id,$request->booking_status,$subject);
        }
        return response()->json(['status' => 'OK', 'message' => 'Booking status updated successfully']);
    }

    public function check_exist_data($request, $id)
    {
        $query = Pets::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_pet_category = $query->where(function ($q) use ($request) {
            $q->where('pet_name', $request->pet_name)->where('user_id', $request->user->id);
        })->first();

        return $check_pet_category;
    }

    public function delete_pet(Request $request)
    {
        $update_pet_status = Pets::where('id', $request->id)->update(['status' => 3]);
        if ($update_pet_status) {
            return response()->json(['status' => 'OK', 'message' => 'Pet deleted successfully.'], 200);
        }
    }

    public function add_to_cart(Request $request, $id, $price)
    {
        $check_cart = DB::table('tbl_cart')->where('user_id', $request->user->id)->where('service_id', $id)->first();
        // if ($check_cart) {
        //     $add_cart = DB::table('tbl_cart')
        //         ->where('id', $check_cart->id)
        //         ->update(['charge' => $price]);
        //     return response()->json(['status' => 'Exist', 'message' => 'Service already added to cart.'], 200);
        // }
        $add_cart = DB::table('tbl_cart')->insert(['user_id' => $request->user->id, 'charge' => $price, 'service_id' => $id]);
        if ($add_cart) {
            return response()->json(['status' => 'OK', 'message' => 'Service added to cart successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to add service to cart.'], 501);
        }
    }
    public function get_cart_services(Request $request)
    {
        $cart_services = DB::table('tbl_cart as a')
            ->join('packages as b', 'a.service_id', '=', 'b.id')
            ->select('b.*', 'a.id as cart_id', 'a.charge as price')->where('b.status', 1)->where('a.user_id',$request->user->id)->where('a.status',1)
            ->get();
        return response()->json(['status' => 'OK', 'data' => $cart_services], 200);
    }
    public function delete_cart_service(Request $request, $id)
    {
        $delete_cart_service = DB::table('tbl_cart')->where('id', $id)->update(['status'=>3]);
        if ($delete_cart_service) {
            return response()->json(['status' => 'OK', 'message' => 'Service deleted from cart successfully.'], 200);
        } else {
            return response()->json(['status' => 'OK', 'message' => 'Failed to delete service from cart.'], 500);
        }
    }

    public function add_address(Request $request)
    {

        $rules = [
            'flat_house_no'         => 'required|string',
            'area_sector_locality'  => 'required|string',
            'city_district'         => 'required|string',
            'state'                 => 'required|string',
            'pincode'               => 'required|digits:6',
            'complete_address'      => 'required|string',
            'email_address'         => 'nullable|email'
        ];
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $inserted = DB::table('tbl_address')->insert([
            'user_id'               => $request->user->id,
            'flat_house_no'         => $request->flat_house_no,
            'area_sector_locality'  => $request->area_sector_locality,
            'city_district'         => $request->city_district,
            'state'                 => $request->state,
            'pincode'               => $request->pincode,
            'complete_address'      => $request->complete_address,
            'email_address'         => $request->email_address
        ]);
        if ($inserted) {
            return response()->json(['status' => 'OK', 'message' => 'Address added successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to add address.'], 500);
        }
    }

    public function get_address(Request $request)
    {
        $addresses = DB::table('tbl_address')->where('status', 1)->where('user_id',$request->user->id)->get();
        return response()->json(['status' => 'OK', 'data' => $addresses], 200);
    }

    public function delete_address(Request $request, $id)
    {
        $deleted = DB::table('tbl_address')->where('id', $id)->update(['status'=>3]);

        if ($deleted) {
            return response()->json(['status' => 'OK', 'message' => 'Address deleted successfully.'], 200);
        } else {
            return response()->json(['status' => 'Error', 'message' => 'Failed to delete address.'], 500);
        }
    }

    public function get_location(Request $request)
    {
        $rules = [
            'lat'         => 'required|string',
            'long'  => 'required|string'
        ];
        $validate = \Myhelper::FormValidator($rules, $request);
        if ($validate != "no") {
            return $validate;
        }
        $apiKey = '9d52cf15543e4b1d9517f51ba60e6961';
        $url = "https://api.opencagedata.com/geocode/v1/json?q={$request->lat}+{$request->long}&key={$apiKey}";
        $response = file_get_contents($url);
        $responseData = json_decode($response, true);
        if (!empty($responseData['results'])) {
            $location = $responseData['results'][0]['formatted'];
            return response()->json(['status' => 'OK', 'data' => $responseData], 200);
        } else {
            return response()->json(['status' => 'Error', 'data' => 'Location not found.'], 404);
        }
    }

    public function update_current_location(Request $request)
    {
        $user = User::findOrFail($request->user->id);
        if (!empty($request->lat) && !empty($request->long)) {
            $apiKey = '9d52cf15543e4b1d9517f51ba60e6961';
            $url = "https://api.opencagedata.com/geocode/v1/json?q={$request->lat}+{$request->long}&key={$apiKey}";
            $response = file_get_contents($url);
            $responseData = json_decode($response, true);

            if (!empty($responseData['results'])) {
                $addressComponents = $responseData['results'][0]['components'];
                $user->_normalized_city = $addressComponents['city'] ?? null;
                $user->_category = $addressComponents['_category'] ?? 'road';
                $user->_type = $addressComponents['_type'] ?? 'road';
                $user->continent = $addressComponents['continent'] ?? null;
                $user->country = $addressComponents['country'] ?? null;
                $user->country_code = $addressComponents['country_code'] ?? null;
                $user->county = $addressComponents['county'] ?? null;
                $user->postcode = $addressComponents['postcode'] ?? null;
                $user->road = $addressComponents['road'] ?? 'unnamed road';
                $user->road_type = $addressComponents['road_type'] ?? 'residential';
                $user->state = $addressComponents['state'] ?? null;
                $user->state_code = $addressComponents['state_code'] ?? null;
                $user->state_district = $addressComponents['state_district'] ?? null;
                $user->suburb = $addressComponents['suburb'] ?? null;
            }
        }
        $user->save();
        return response()->json(['status' => 'OK', 'message' => 'Profile updated successfully'], 200);
    }

    public function get_pages(Request $request, $title)
    {
        $page = Page::where('page_name', $title)->first();
        if ($page) {
            return response()->json(['status' => 'OK', 'data' => $page], 200);
        } else {
            return response()->json(['status' => 'Error', 'data' => 'Page not found.'], 404);
        }
    }
    
      public function createOrder(Request $request)
    {


     

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $amount = $request->amount; // Amount in INR
        $receiptId = 'BOOKING_' . Str::random(8); // Custom receipt ID

        try {
            $orderData = [
                'receipt'         => $receiptId,
                'amount'          => $amount * 100, // Amount in paisa
                'currency'        => 'INR',
                'payment_capture' => 1 // Auto capture after payment
            ];

            $order = $api->order->create($orderData); // Creates Razorpay Order

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'receipt' => $order['receipt']
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function payment(Request $request)
    {

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        try {
            // Fetch the payment details
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            // Check if the payment is authorized
            if ($payment->status === 'authorized' || $payment->status === 'captured') {
                // Capture the payment
                if ($payment->status === 'authorized') {
                    $payment->capture(['amount' => $payment->amount]); // Amount is in paisa
                }
                // Store the payment details
                $insert =  DB::table('payment_transactions')->insertGetId([
                    'user_id'     => $request->user->id,
                    'booking_id'  => $request->booking_id ?? null,
                    'payment_id'  => $payment->id,
                    'order_id'    => $payment->order_id ?? null,
                    'method'      => $payment->method,
                    'amount'      => $payment->amount / 100, // convert from paisa to INR
                    'currency'    => $payment->currency,
                    'status'      => $payment->status,
                    'response'    => json_encode($payment),
                    'created_at'  => now(), // manually add if timestamps aren't auto-handled
                    'updated_at'  => now()
                ]);

                return response()->json(['success' => true, 'message' => 'Payment captured and saved.', 'data' => $insert]);
            } else {
                return response()->json(['success' => false, 'message' => 'Payment not authorized.']);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function handle(Request $request)
{
    // Remove this in production
    echo 234234; die;

    $data = $request->getContent();
    $signature = $request->header('X-Razorpay-Signature');
    $webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');

    // Verify signature
    $expectedSignature = hash_hmac('sha256', $data, $webhookSecret);

    if (!hash_equals($expectedSignature, $signature)) {
        Log::warning('Razorpay webhook signature mismatch');
        return response('Signature mismatch', 400);
    }

    $payload = json_decode($data, true);
    $event = $payload['event'];

    Log::info('Razorpay Webhook Event: ' . $event, $payload);

    if ($event === 'payment.captured') {
        $payment = $payload['payload']['payment']['entity'];
        $paymentId = $payment['id'];
        $amount = $payment['amount'] / 100; // convert to INR
        $status = $payment['status'];

        // ✅ Update your database
        DB::table('payment_transactions')
            ->where('payment_id', $paymentId)
            ->update([
                'status'     => $status,
                'amount'     => $amount,
                'response'   => json_encode($payment),
                'updated_at' => now()
            ]);

    } elseif ($event === 'payment.failed') {
        $payment = $payload['payload']['payment']['entity'];
        $paymentId = $payment['id'];
        $status = $payment['status'];

        // Update DB with failure status
        DB::table('payment_transactions')
            ->where('payment_id', $paymentId)
            ->update([
                'status'     => $status,
                'response'   => json_encode($payment),
                'updated_at' => now()
            ]);
    }

    return response()->json(['status' => 'ok']);

}
}
