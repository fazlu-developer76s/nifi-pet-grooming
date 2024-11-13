<?php

namespace App\Http\Controllers;

use App\Models\Refer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferController extends Controller
{
    public function index()
    {
        $title = "Refer And Earn Setup List";
        $allrefer = Refer::where('status','!=',3)->get();
        return view('refer.index', compact('title', 'allrefer'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'coupon_code' => 'required',
                'code_type' => 'required',
                'coupon_value' => 'required|integer',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->coupon_code == $request->coupon_code) {
                    $message .= "Coupon Code: ";
                }

                if ($message) {
                    return redirect()->route('refer')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $package = new Refer();
            $package->coupon_code = $request->coupon_code;
            $package->code_type = $request->code_type;
            $package->value = $request->coupon_value;
            if($request->is_coupon_reused){
                $package->is_coupon_reused = $request->is_coupon_reused;
            }
            if($request->expiry_date){
                $package->expiry_date = $request->expiry_date;
            }
            $package->status = $request->status;
            $package->save();
            return redirect()->route('refer')->with('success', 'Coupon Added Successfully');
        }
    }



    public function destroy($id)
    {
        $package = Refer::findOrFail($id);
        $package->status = 3;
        $package->update();
        return redirect()->route('refer')->with('success', 'Coupon deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Refer::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_route = $query->where(function ($q) use ($request) {
            $q->where('coupon_code', $request->coupon_code);
        })->first();

        return $check_route;
    }
    public function refer_earn(Request $request)
    {
        if ($request->isMethod('post')) {


            $updateArray = [
                'is_on' => ($request->is_on) ? $request->is_on : 2 ,
                'is_profit' => ($request->is_profit) ? $request->is_profit : 2,
                'billing_no' => ($request->billing_no) ? $request->billing_no : 0,
            ];
            $update_data = DB::table('refer_and_earn')
                ->where('id', $request->hidden_id)
                ->update($updateArray);

            if ($update_data) {
                return redirect()->route('refer.earn')->with('success', 'Updated Successfully');
            }
            return redirect()->back()->with('error', 'Failed to update data. Please try again.');
        }

        // Fetch data for GET request
        $earn_refer = DB::table('refer_and_earn')->get();
        $title = "Refer And Earn";

        return view('refer.refer_and_earn', compact('title', 'earn_refer'));
    }

}
