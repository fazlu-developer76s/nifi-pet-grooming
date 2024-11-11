<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetCategory;
use Illuminate\Support\Facades\Storage;

class PetCategoryController extends Controller
{
    public function index()
    {
        $title = "Pet Category List";
        $allcategory = PetCategory::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('pet_category.index', compact('title', 'allcategory'));
    }

    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required',
            ]);
            $check_data = $this->check_exist_data($request, null);
            if ($check_data) {
                $message = '';
                if ($check_data->title == $request->title) {
                    $message .= "Pet Category ";
                }
                if ($message) {
                    return redirect()->route('pet.category')
                        ->with('error', trim($message) . ' Already Exists');
                }
            }
            $pet_category = new PetCategory();
            $pet_category->title = $request->title;
            $pet_category->status = $request->status;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filePath = $file->store('pet_category', 'public');
                $pet_category->image = $filePath;
            }
            $pet_category->save();
            return redirect()->route('pet.category')->with('success', 'Pet Category Added Successfully');
        }
    }

    public function edit($id)
    {
        $title = "Edit Pet Category";
        $get_category = PetCategory::where('status', '!=', 3)->where('id', $id)->first();
        $allcategory = PetCategory::where('status', '!=', '3')->orderBy('id', 'desc')->get();
        return view('pet_category.index', compact('title', 'allcategory','get_category'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
        ]);
        $check_data = $this->check_exist_data($request, $request->hidden_id);
        if ($check_data) {
            $message = '';
            if ($check_data->title == $request->title) {
                $message .= "Pet Category ";
            }
            if ($message) {
                return redirect()->route('category.edit', ['id' => $request->hidden_id])
                    ->with('error', trim($message) . ' Already Exists');
            }
        }
        $pet_category = PetCategory::findOrFail($request->hidden_id);
        $pet_category->title = $request->title;
        $pet_category->status = $request->status;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('pet_category', 'public');
            $pet_category->image = $filePath;
            if ($request->filled('hidden_image') && Storage::disk('public')->exists($request->hidden_image)) {
                Storage::disk('public')->delete($request->hidden_image);
            }
        }
        $pet_category->updated_at = date('Y-m-d H:i:s');
        $pet_category->save();
        return redirect()->route('pet.category')->with('success', 'Pet Category Updated Successfully');
    }


    public function destroy($id)
    {
        $pet_category = PetCategory::findOrFail($id);
        $pet_category->status = 3;
        $pet_category->update();
        return redirect()->route('pet.category')->with('success', 'Pet Category deleted successfully.');
    }

    public function check_exist_data($request, $id)
    {
        $query = PetCategory::where('status', '!=', 3);
        if ($id !== null) {
            $query->where('id', '!=', $id);
        }
        $check_pet_category = $query->where(function ($q) use ($request) {
            $q->where('title', $request->title);
        })->first();

        return $check_pet_category;
    }
}
