<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Route;
use App\Models\Routezip;
use App\Models\Assignroute;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AssignrouteController extends Controller
{
    public function index()
    {

        $title = "Route Assign List";
        $allroute = Route::where('status', '!=', '3')->orderBy('id', 'asc')->get();
        $alluser = Member::where('status', '!=', '3')->where('role_id', 3)->orderBy('id', 'asc')->get();
        $allrouteassign = DB::table('assignroutes')->leftJoin('users', 'assignroutes.user_id', '=', 'users.id')->leftJoin('routes', 'assignroutes.route_id', '=', 'routes.id')->select('assignroutes.*', 'routes.route', 'routes.title as title', 'users.name')->where('assignroutes.status', '!=', '3')->orderby('assignroutes.id', 'asc')->get();
        return view('routeassign.index', compact('title', 'allrouteassign', 'allroute', 'alluser'));
    }

    public function create(Request $request)
    {

        if ($request->method() == 'POST') {
            $request->validate([
                'route_id' => 'required',
                'user_id' => 'required',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = "Route Already Assign This User  ";
                return redirect()->route('routeassign')
                    ->with('error', trim($message));
            } else {
                $routeassign = new Assignroute();
                $routeassign->route_id = $request->route_id;
                $routeassign->user_id = $request->user_id;
                $routeassign->status = $request->status;
                $routeassign->save();
                $insert_id = $routeassign->id;
                DB::table('route_logs')->insert(['route_assign_id' => $insert_id, 'user_id' => $request->user_id, 'route_id' => $request->route_id]);
            }
            return redirect()->route('routeassign')->with('success', 'Route assigned successfully');
        }
    }

    public function edit($id)
    {
        $title = "Edit Route Assign";
        $allroute = Route::where('status', '!=', '3')->orderBy('id', 'asc')->get();
        $alluser = Member::where('status', '!=', '3')->where('role_id', 3)->orderBy('id', 'asc')->get();
        $allrouteassign = DB::table('assignroutes')->leftJoin('users', 'assignroutes.user_id', '=', 'users.id')->leftJoin('routes', 'assignroutes.route_id', '=', 'routes.id')->select('assignroutes.*', 'routes.route', 'users.name')->where('assignroutes.status', '!=', '3')->orderby('assignroutes.id', 'asc')->get();
        $assignroute = Assignroute::where('status', '!=', 3)->where('id', $id)->first();
        return view('routeassign.index', compact('title', 'allroute', 'alluser', 'allrouteassign', 'assignroute'));
    }

    public function update(Request $request)
    {

        $request->validate([
            // 'route_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';
            if ($check_data->zip_code == $request->zip_code) {
                $message .= "Route Assign ";
            }
            if ($message) {
                return redirect()->route('routeassign')
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        $routeassign = Assignroute::findOrFail($request->hidden_id);
        if ($routeassign->user_id != $request->user_id) {
            DB::table('route_logs')->insert(['route_assign_id' => $request->hidden_id, 'user_id' => $request->user_id, 'route_id' => $routeassign->route_id]);
        }
        // $routeassign->route_id = $request->route_id;
        $routeassign->user_id = $request->user_id;
        $routeassign->status = $request->status;
        $routeassign->save();
        $insert_id = $request->hidden_id;

        return redirect()->route('routeassign')->with('success', 'Route Assign Update Successfully');
    }


    public function destroy($id)
    {
        $routezip = Assignroute::findOrFail($id);
        $routezip->status = 3;
        $routezip->update();
        return redirect()->route('routeassign')->with('success', 'Route Assign deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Assignroute::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_routezip = $query->where(function ($q) use ($request) {
            $q->where('route_id', $request->route_id)->where('user_id', $request->user_id);
        })->first();

        return $check_routezip;
    }

    public function update_check_exist_data($request, $id)
    {
        $query = Assignroute::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_routezip = $query->where(function ($q) use ($request) {
            $q->where('route_id', $request->route_id)->orWhere('user_id', $request->user_id);
        })->first();

        return $check_routezip;
    }

    public function view($id)
    {

        $title = "View Route Assign";
        $assign_route = DB::table('route_logs')->Join('users', 'users.id', '=', 'route_logs.user_id')
        ->Join('routes', 'routes.id', '=', 'route_logs.route_id')
        ->select('route_logs.*', 'routes.route as route_no', 'routes.title as route_title', 'users.name as username')
        ->where('route_logs.route_id', $id)->where('route_logs.status','!=', '3')->where('users.status','!=', '3')->where('routes.status','!=', '3')
        ->orderBy('route_logs.id','asc')->get();

        return view('routeassign.view', compact('title', 'assign_route'));
    }

    public function remove_route($id)
    {
        $get_route_assign = Assignroute::where('status', 1)->where('id', $id)->first();

        if ($get_route_assign) {
            $update_remove_route_date =  DB::table('route_logs')->where('id', $get_route_assign->id)->update(['updated_at' => date('Y-m-d H:i:s')]);
        }
        DB::table('assignroutes')->where('id', $get_route_assign->id)->delete();
        return redirect()->route('routeassign')->with('success', 'Remove Route successfully');
    }
}
