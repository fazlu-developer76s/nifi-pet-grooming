<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller
{
    // Show the edit form
    public function edit($id)
    {

        $pages = Page::findOrFail($id);
        return view('pages.edit', compact('pages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|image|mimes:jpg,jpeg,png,svg',
            'paragraph' => 'required|string',
        ]);
        $pages = Page::findOrFail($id);
        $pages->title = $request->title;
        $pages->paragraph = $request->paragraph;
        if ($request->hasFile('image')) {
            $pages->image = $request->file('image')->store('pages', 'public');
        }
        $pages->save();
        return redirect()->route('pages.edit', $pages->id)
                         ->with('success', 'Pages information updated successfully.');
    }

}
