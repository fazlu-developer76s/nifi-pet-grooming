<?php

namespace App\Http\Controllers;
use App\Models\Payment_mode;

use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    //
    public function index()
    {
        $title = "Payment Mode List";
        $payment_mode = Payment_mode::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('Payment_mode.index', compact('title', 'payment_mode'));
    }

    public function create(Request $request)
    {

        if ($request->method() == 'POST') {
            $request->validate([
                'title' => 'required',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->title == $request->title) {
                    $message .= "Payment Mode ";
                }

                if ($message) {
                    return redirect()->route('payment_mode')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $payment_mode = new Payment_mode();
            $payment_mode->title = $request->title;
            $payment_mode->status = $request->status;
            $payment_mode->save();
            return redirect()->route('payment_mode')->with('success', 'Payment Mode Added Successfully');
        }

        $title = "Add Payment Mode";
        return view('Payment_mode.create', compact('title'));
    }

    public function edit($id)
    {
        $title = "Edit Payment Mode";
        $get_payment_mode = Payment_mode::where('status', '!=', 3)->where('id', $id)->first();
        $title = "Payment Mode List";
        $payment_mode = Payment_mode::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('Payment_mode.index', compact('title', 'payment_mode','get_payment_mode'));

    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';

            if ($check_data->title == $request->title) {
                $message .= "Payment_mode ";
            }
            if ($message) {
                return redirect()->route('Payment_mode.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        $payment_mode = Payment_mode::findOrFail($request->hidden_id);
        $payment_mode->title = $request->title;
        $payment_mode->status = $request->status;
        $payment_mode->save();
        return redirect()->route('payment_mode')->with('success', 'Payment mode Updated Successfully');
    }


    public function destroy($id)
    {
        $payment_mode = Payment_mode::findOrFail($id);
        $payment_mode->status = 3;
        $payment_mode->update();
        return redirect()->route('payment_mode')->with('success', 'Payment mode deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Payment_mode::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_payment_mode = $query->where(function ($q) use ($request) {
            $q->where('title', $request->title);
        })->first();

        return $check_payment_mode;
    }

}
