<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CmsModal;
class CmsController extends Controller
{
    public function company_info(Request $request)
    {
        if ($request->method() == 'POST') {

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

            $company = CmsModal::findOrFail(1);
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
        $title = "Add Member";
        $company = CmsModal::findOrFail(1);
        return view('company.edit', compact('company'));
        return view('member.create', compact('title', 'get_role', 'allroute'));
    }
}
