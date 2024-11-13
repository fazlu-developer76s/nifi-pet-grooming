<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $title = "Service List";
        $allservice = Service::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('service.index', compact('title', 'allservice'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'title' => 'required',
                'service_charge' => 'required|integer',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->title == $request->title) {
                    $message .= "Service ";
                }

                if ($message) {
                    return redirect()->route('service')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $service = new Service();
            $service->title = $request->title;
            $service->service_charge = $request->service_charge;
            $service->status = $request->status;
            $service->save();
            return redirect()->route('service')->with('success', 'Service Added Successfully');
        }
    }

    public function edit($id)
    {
        $title = "Edit Service";
        $get_service = Service::where('status', '!=', 3)->where('id', $id)->first();
        $allservice = Service::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('service.index', compact('title', 'allservice','get_service'));

    }

    public function update(Request $request)
    {
        $request->validate([

            'title' => 'required',
            'service_charge' => 'required|integer',
            'status' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';
            if ($check_data->title == $request->title) {
                $message .= "Service ";
            }
            if ($message) {
                return redirect()->route('service.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }
        $service = Service::findOrFail($request->hidden_id);
        $service->title = $request->title;
        $service->service_charge = $request->service_charge;
        $service->status = $request->status;
        $service->updated_at = date('Y-m-d H:i:s');
        $service->save();
        return redirect()->route('service')->with('success', 'Service Updated Successfully');
    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->status = 3;
        $service->update();
        return redirect()->route('service')->with('success', 'Service deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Service::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_route = $query->where(function ($q) use ($request) {
            $q->where('title', $request->title);
        })->first();

        return $check_route;
    }

    public function addservice_package(Request $request) {

        $check_service = DB::table('add_package_service')
            ->where('service_id', $request->service_id)
            ->where('package_id', $request->package_id)
            ->first();

        if (!$check_service) {
            DB::table('add_package_service')->insert([
                'service_id' => $request->service_id,
                'package_id' => $request->package_id,
                'status' => $request->status,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Service added to package successfully.']);
        }
        DB::table('add_package_service')
            ->where('id', $check_service->id)
            ->update(['status' => $request->status]);

        return response()->json(['status' => 'success', 'message' => 'Service updated in package successfully.']);
    }

}
