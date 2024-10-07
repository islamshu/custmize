<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
{
    $colors = Color::all();
    return view('dashboard.colors.index', compact('colors'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:7',
    ]);

    Color::create([
        'name' => $request->name,
        'code' => $request->code,
    ]);
    return response()->json(['success' => 'true',200]);


    // return response()->json(['success' => __('Color added successfully')]);
}
public function edit(Color $color)
    {
        return view('dashboard.colors._edit')->with('colors',Color::get())->with('color',$color);

    }
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:7',
    ]);

    $color = Color::find($id);
    $color->update([
        'name' => $request->name,
        'code' => $request->code,
    ]);

    return response()->json(['success' => __('Color updated successfully')]);
}

public function destroy(Color $color)
{
   
    $color->delete();

    return redirect()->route('colors.index')->with('success', __('Deleted successfully'));
}



}
