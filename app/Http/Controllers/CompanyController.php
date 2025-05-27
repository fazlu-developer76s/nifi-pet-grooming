<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    // Show the edit form
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    // Handle the update request
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:1024',
            'address' => 'required|string|max:500',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        // Find the company
        $company = Company::findOrFail($id);

        // Update the company's details
        $company->name = $request->name;

        if ($request->hasFile('logo')) {
            $company->logo = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('favicon')) {
            $company->favicon = $request->file('favicon')->store('favicons', 'public');
        }

        $company->address = $request->address;
        $company->email = $request->email;
        $company->mobile = $request->mobile;
        $company->facebook = $request->facebook;
        $company->twitter = $request->twitter;
        $company->instagram = $request->instagram;
        $company->linkedin = $request->linkedin;

        // Save the updated company
        $company->save();

        // Redirect with success message
        return redirect()->route('company.edit', $company->id)
                         ->with('success', 'Company information updated successfully.');
    }

     public function booking($id)
    {
        $title = 'Booking List';
        $bookings = DB::table('tbl_pet_bookings as a')
            ->leftJoin('users as b', 'a.customer_id', '=', 'b.id')
            ->leftJoin('users as c', 'a.accept_user_id', '=', 'c.id')
            ->select('a.*', 'b.name as post_user_name', 'c.name as accept_user_name')
            ->where('a.booking_status', $id)
            ->where('a.status', '!=', 3)->orderBy('a.id', 'desc')
            ->get();
        return view('company.booking_list', compact('bookings'));
    }

    public function t_shirt_order()
    {
        $title = 'T-Shirt Order List';
        $orders = DB::table('t_shirt_transaction as a')
            ->leftJoin('users as b', 'a.user_id', '=', 'b.id')
            ->select('a.*', 'b.name as user_name', 'b.email as user_email', 'b.mobile_no as user_mobile_no')
            ->orderBy('a.id', 'desc')
            ->get();
        return view('company.tshirt_order_list', compact('orders'));
    }
}
