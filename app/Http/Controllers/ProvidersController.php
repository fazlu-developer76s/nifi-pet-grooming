<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Providers;

class ProvidersController extends Controller
{
    public function index()
    {
        $title = "Providers List";
        $allroute = Providers::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('providers.index', compact('title', 'allroute'));
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
                if ($check_data->route == $request->route) {
                    $message .= "Providers ";
                }

                if ($message) {
                    return redirect()->route('providers')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $route = new Providers();

            $route->title = $request->title;
            $route->status = $request->status;
            $route->save();
            return redirect()->route('providers')->with('success', 'ZipCode Added Successfully');
        }

        $title = "Add Providers";
        return view('providers.create', compact('title'));
    }

    public function edit($id)
    {
        $title = "Edit Providers";
        $get_route = Providers::where('status', '!=', 3)->where('id', $id)->first();
        $title = "Providers List";
        $allroute = Providers::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('providers.index', compact('title', 'allroute','get_route'));

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

            if ($check_data->route == $request->route) {
                $message .= "Providers ";
            }
            if ($message) {
                return redirect()->route('providers.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }

        $route = Providers::findOrFail($request->hidden_id);

        $route->title = $request->title;
        $route->status = $request->status;
        $route->save();
        return redirect()->route('providers')->with('success', 'Providers Updated Successfully');
    }


    public function destroy($id)
    {
        $route = Providers::findOrFail($id);
        $route->status = 3;
        $route->update();
        return redirect()->route('providers')->with('success', 'Providers deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Providers::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_route = $query->where(function ($q) use ($request) {
            $q->where('title', $request->title);
        })->first();

        return $check_route;
    }
}
