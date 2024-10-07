<?php

namespace App\Http\Controllers;

use App\Models\TypeCategory;
use Illuminate\Http\Request;

class TypeCategoryController extends Controller
{
    public function index()
{
    $types = TypeCategory::all();
    return view('dashboard.types.index', compact('types'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    TypeCategory::create([
        'name' => $request->name,
    ]);
    return response()->json(['success' => 'true',200]);


    // return response()->json(['success' => __('TypeCategory added successfully')]);
}
public function edit(TypeCategory $TypeCategory)
    {
        return view('dashboard.types._edit')->with('types',TypeCategory::get())->with('TypeCategory',$TypeCategory);

    }
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $TypeCategory = TypeCategory::find($id);
    $TypeCategory->update([
        'name' => $request->name,
    ]);

    return response()->json(['success' => __('TypeCategory updated successfully')]);
}

public function destroy(TypeCategory $TypeCategory)
{
   
    $TypeCategory->delete();

    return redirect()->route('types.index')->with('success', __('Deleted successfully'));
}



}
