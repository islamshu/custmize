<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
{
    $sizes = Size::all();
    return view('dashboard.sizes.index', compact('sizes'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    Size::create([
        'name' => $request->name,
    ]);
    return response()->json(['success' => 'true',200]);


    // return response()->json(['success' => __('Size added successfully')]);
}
public function edit(Size $size)
    {
        return view('dashboard.sizes._edit')->with('sizes',Size::get())->with('size',$size);

    }
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $size = Size::find($id);
    $size->update([
        'name' => $request->name,
    ]);

    return response()->json(['success' => __('Size updated successfully')]);
}

public function destroy(Size $size)
{
   
    $size->delete();

    return redirect()->route('sizes.index')->with('success', __('Deleted successfully'));
}



}
