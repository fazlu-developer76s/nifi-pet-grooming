<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tshirt;
use Illuminate\Support\Facades\Storage;

class TshirtController extends Controller
{
    public function index()
    {
        $title = "T-Shirt List";
        $alltshirt = Tshirt::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('pet_tshirt.index', compact('title', 'alltshirt'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required',
                    's' => 'required|integer',
                'm' => 'required|integer',
                'l' => 'required|integer',
                'xl' => 'required|integer',
                'xxl' => 'required|integer',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->title == $request->title) {
                    $message .= "T-Shirt ";
                }
                if ($message) {
                    return redirect()->route('tshirt')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $pet_tshirt = new Tshirt();
            $pet_tshirt->title = $request->title;
            $pet_tshirt->status = $request->status;
            $pet_tshirt->s = $request->s;
            $pet_tshirt->m = $request->m;
            $pet_tshirt->l = $request->l;
            $pet_tshirt->xl = $request->xl;
            $pet_tshirt->xxl = $request->xxl;
            $pet_tshirt->description = $request->description;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filePath = $file->store('pet_tshirt', 'public');
                $pet_tshirt->image = $filePath;
            }
            $pet_tshirt->save();
            return redirect()->route('tshirt')->with('success', 'T-Shirt Added Successfully');
        }
    }

    public function edit($id)
    {
        $title = "Edit T-Shirt";
        $get_tshirt = Tshirt::where('status', '!=', 3)->where('id', $id)->first();
        $alltshirt = Tshirt::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('pet_tshirt.index', compact('title', 'alltshirt','get_tshirt'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
                 's' => 'required|integer',
                'm' => 'required|integer',
                'l' => 'required|integer',
                'xl' => 'required|integer',
                'xxl' => 'required|integer',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';
            if ($check_data->title == $request->title) {
                $message .= "T-Shirt ";
            }
            if ($message) {
                return redirect()->route('tshirt.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }
        $pet_tshirt = Tshirt::findOrFail($request->hidden_id);
        $pet_tshirt->title = $request->title;
        $pet_tshirt->status = $request->status;
          $pet_tshirt->s = $request->s;
            $pet_tshirt->m = $request->m;
            $pet_tshirt->l = $request->l;
            $pet_tshirt->xl = $request->xl;
            $pet_tshirt->xxl = $request->xxl;
            $pet_tshirt->description = $request->description;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('pet_tshirt', 'public');
            $pet_tshirt->image = $filePath;
            if ($request->filled('hidden_image') && Storage::disk('public')->exists($request->hidden_image)) {
                Storage::disk('public')->delete($request->hidden_image);
            }
        }
        $pet_tshirt->updated_at = date('Y-m-d H:i:s');
        $pet_tshirt->save();
        return redirect()->route('tshirt')->with('success', 'T-Shirt Updated Successfully');
    }


    public function destroy($id)
    {
        $pet_tshirt = Tshirt::findOrFail($id);
        $pet_tshirt->status = 3;
        $pet_tshirt->update();
        return redirect()->route('tshirt')->with('success', 'T-Shirt deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = Tshirt::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_pet_tshirt = $query->where(function ($q) use ($request) {
            $q->where('title', $request->title);
        })->first();

        return $check_pet_tshirt;
    }
}
