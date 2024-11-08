<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    //
    public function index()
    {
        $title = "Bank Details List";
        $bank = Bank::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('bank.index', compact('title', 'bank'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'account_no' => 'required',
                'account_name' => 'required',
                'bank_name' => 'required',
                'ifsc_code' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->account_no == $request->account_no) {
                    $message .= "Bank Details ";
                }

                if ($message) {
                    return redirect()->route('bank')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $bank = new bank();
            $bank->account_no = $request->account_no;
            $bank->account_name = $request->account_name;
            $bank->bank_name = $request->bank_name;
            $bank->ifsc_code = $request->ifsc_code;
            $bank->type = $request->type;
            $bank->used_for = $request->used_for;
            $bank->status = $request->status;
            $bank->save();
            return redirect()->route('bank')->with('success', 'Bank Details Added Successfully');
        }

        $title = "Add Bank Details";
        return view('bank.create', compact('title'));
    }

    public function edit($id)
    {
        $title = "Edit Bank Details";
        $get_bank = Bank::where('status', '!=', 3)->where('id', $id)->first();
        $title = "Bank Details List";
        $bank = Bank::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('bank.index', compact('title', 'bank','get_bank'));

    }

    public function update(Request $request)
    {
        $request->validate([
           'account_no' => 'required',
           'account_name' => 'required',
           'bank_name' => 'required',
           'ifsc_code' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';

            if ($check_data->title == $request->title) {
                $message .= "bank ";
            }
            if ($message) {
                return redirect()->route('bank.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        $bank = Bank::findOrFail($request->hidden_id);
        $bank->account_no = $request->account_no;
        $bank->account_name = $request->account_name;
        $bank->bank_name = $request->bank_name;
        $bank->ifsc_code = $request->ifsc_code;
        $bank->type = $request->type;
        $bank->used_for = $request->used_for;
        $bank->status = $request->status;
        $bank->save();
        return redirect()->route('bank')->with('success', 'Bank Details Updated Successfully');
    }


    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->status = 3;
        $bank->update();
        return redirect()->route('bank')->with('success', 'Bank Details deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Bank::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_bank = $query->where(function ($q) use ($request) {
            $q->where('account_no', $request->account_no);
        })->first();

        return $check_bank;
    }
}
