<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index()
    {
        $title = "Package List";
        $service = Service::where('status', 1)->get();
        $allpackage = Package::where('status', '!=', 3)->orderBy('id','desc')->get();
        return view('package.index', compact('title', 'allpackage', 'service'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'title' => 'required',
                'small_charge' => 'required|integer',
                'large_charge' => 'required|integer',
                'gaint_charge' => 'required|integer',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->title == $request->title) {
                    $message .= "Package ";
                }

                if ($message) {
                    return redirect()->route('package')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $package = new Package();
            $package->title = $request->title;
            $package->small_charge = $request->small_charge;
            $package->large_charge = $request->large_charge;
            $package->gaint_charge = $request->gaint_charge;
            $package->tax = $request->tax;
            $package->status = $request->status;
            $package->description = $request->description;
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('hotel_images', 'public');
                $package->image = $path;
            }
            $package->save();
            if ($request->hasFile('hotel_images')) {
                foreach ($request->file('hotel_images') as $image) {
                    $filePath = $image->store('hotel_images', 'public');
                    DB::table('packages_image')->insert(['package_id' => $package->id,  'image' => $filePath]);
                }
            }
            return redirect()->route('package')->with('success', 'Package Added Successfully');
        }
    }

    public function edit($id)
    {
        $title = "Edit Package";
        $get_pack = Package::where('status', '!=', 3)->where('id', $id)->get();
        $get_package = [];
        foreach ($get_pack as $package){
            $package->images = DB::table('packages_image')->where('status',1)->where('package_id',$package->id)->get();
            $get_package[] = $package;
        }
        $allpackage = Package::where('status', '!=', 3)->orderBy('id','desc')->get();
        $service = Service::where('status', 1)->get();
        return view('package.index', compact('title', 'allpackage', 'get_package', 'service'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'small_charge' => 'required|integer',
            'large_charge' => 'required|integer',
            'gaint_charge' => 'required|integer',
            'status' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';
            if ($check_data->title == $request->title) {
                $message .= "Package ";
            }
            if ($message) {
                return redirect()->route('package.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        $package = Package::findOrFail($request->hidden_id);
        $package->title = $request->title;
        $package->small_charge = $request->small_charge;
        $package->large_charge = $request->large_charge;
        $package->gaint_charge = $request->large_charge;
        $package->tax = $request->tax;
        $package->status = $request->status;
        $package->description = $request->description;
        $package->updated_at = date('Y-m-d H:i:s');
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('hotel_images', 'public');
            $package->image = $path;
        }
        $package->save();
        if ($request->hasFile('hotel_images')) {
            foreach ($request->file('hotel_images') as $image) {
                $filePath = $image->store('hotel_images', 'public');
                DB::table('packages_image')->insert(['package_id' => $package->id,  'image' => $filePath]);
            }
        }
        return redirect()->route('package')->with('success', 'Package Updated Successfully');
    }


    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->status = 3;
        $package->update();
        return redirect()->route('package')->with('success', 'Package deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Package::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_route = $query->where(function ($q) use ($request) {
            $q->where('title', $request->title);
        })->first();

        return $check_route;
    }

    public function delete_image(Request $request)
    {
        $image = DB::table('packages_image')->where('id', $request->id)->update(['status' => 3]);
        if ($image) {
            // if ($image->image) {
            //     Storage::disk('public')->delete($image->image);
            // }
            // $image->delete();
            echo 1;
            die;
            return response()->json(['success' => 'Image deleted successfully.']);
        } else {
            return response()->json(['error' => 'Image not found.']);
        }
    }
}
