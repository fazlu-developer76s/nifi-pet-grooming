<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    public function index()
    {
        $title = "Route List";
        $allroute = Route::where('status', '!=', '3')->orderBy('id', 'asc')->get();
        return view('route.index', compact('title', 'allroute'));
    }

    public function create(Request $request)
    {

        if ($request->method() == 'POST') {
            $request->validate([
                'route' => 'required|integer',
                'title' => 'required',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->route == $request->route) {
                    $message .= "Route ";
                }

                if ($message) {
                    return redirect()->route('route')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $route = new Route();
            $route->route = $request->route;
            $route->title = $request->title;
            $route->status = $request->status;
            $route->save();
            return redirect()->route('route')->with('success', 'ZipCode Added Successfully');
        }

        $title = "Add Route";
        return view('route.create', compact('title'));
    }

    public function edit($id)
    {
        $title = "Edit Route";
        $get_route = Route::where('status', '!=', 3)->where('id', $id)->first();
        $title = "Route List";
        $allroute = Route::where('status', '!=', '3')->orderBy('id', 'asc')->get();
        return view('route.index', compact('title', 'allroute','get_route'));

    }

    public function update(Request $request)
    {
        $request->validate([
            'route' => 'required|integer',
            'title' => 'required',
            'status' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';

            if ($check_data->route == $request->route) {
                $message .= "Route ";
            }
            if ($message) {
                return redirect()->route('route.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        $route = Route::findOrFail($request->hidden_id);
        $route->route = $request->route;
        $route->title = $request->title;
        $route->status = $request->status;
        $route->save();
        return redirect()->route('route')->with('success', 'Route Updated Successfully');
    }


    public function destroy($id)
    {
        $route = Route::findOrFail($id);
        $route->status = 3;
        $route->update();
        return redirect()->route('route')->with('success', 'Route deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Route::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_route = $query->where(function ($q) use ($request) {
            $q->where('route', $request->route);
        })->first();

        return $check_route;
    }
}
