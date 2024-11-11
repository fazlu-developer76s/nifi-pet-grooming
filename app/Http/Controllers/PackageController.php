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
        $service = Service::where('status',1)->get();
        $allpackage = DB::table('packages')->
        join('services','services.id','=','packages.service_id')
        ->select('packages.*','services.title as service_title')
        ->where('packages.status','!=',3)->where('services.status',1)
        ->orderBy('packages.id','desc')->get();
        return view('package.index', compact('title', 'allpackage','service'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'service_id' => 'required',
                'title' => 'required',
                'package_charge' => 'required|integer',
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
            $package->service_id = $request->service_id;
            $package->title = $request->title;
            $package->package_charge = $request->package_charge;
            $package->status = $request->status;
            $package->save();
            return redirect()->route('package')->with('success', 'Package Added Successfully');
        }
    }

    public function edit($id)
    {
        $title = "Edit Package";
        $get_package = Package::where('status', '!=', 3)->where('id', $id)->first();
        $allpackage = DB::table('packages')->
        leftJoin('services','services.id','=','packages.service_id')
        ->select('packages.*','services.title as service_title')
        ->where('packages.status','!=',3)->where('services.status',1)
        ->orderBy('packages.id','desc')->get();
        $service = Service::where('status',1)->get();
        return view('package.index', compact('title', 'allpackage','get_package','service'));

    }

    public function update(Request $request)
    {
        $request->validate([

            'service_id' => 'required',
            'title' => 'required',
            'package_charge' => 'required|integer',
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
        $package->service_id = $request->service_id;
        $package->title = $request->title;
        $package->package_charge = $request->package_charge;
        $package->status = $request->status;
        $package->updated_at = date('Y-m-d H:i:s');
        $package->save();
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
}
