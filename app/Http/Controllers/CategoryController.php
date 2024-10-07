<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(relations: 'children')->whereNull('parent_id')->get();
        return view('dashboard.categories.index', compact('categories'));

    }
    public function index_cat()
    {
        $categories = Category::with(relations: 'children')->whereNotNull('parent_id')->get();
        return view('dashboard.categories.cat_index', compact('categories'));

    }
    public function getSubcategories($parentId)
{
    $subcategories = Category::where('parent_id', $parentId)->pluck('name', 'id');
    return response()->json($subcategories);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with(relations: 'children')->whereNull('parent_id')->get();
         return view('dashboard.categories.create', compact('categories'));
    }
    public function create_cat()
    {
        $categories = Category::with(relations: 'children')->whereNull('parent_id')->get();
         return view('dashboard.categories.cat_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the form inputs including the image
    $request->validate([
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:categories,id',
        'image' => 'required', // Image validation
    ]);

    // Handle the image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('categories'); // Store image in 'public/categories'
    } else {
    }

    // Create the category
    Category::create([
        'name' => $request->input('name'),
        'parent_id' => $request->input('parent_id'),
        'image' => $imagePath, // Store the image path
    ]);
    // addToJsonFile($request->name);
      
    if($request->parent_id != null){
        return redirect()->route('index_cat')->with('success',__('Added Successfuly'));
    }

    return redirect()->route('categories.index')->with('success',__('Added Successfuly'));
}
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::with(relations: 'children')->whereNull('parent_id')->get();
        return view('dashboard.categories.edit', compact('categories','category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Handle the image upload and replacement if necessary
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete($category->image); // Remove the old image
            }
            $imagePath = $request->file('image')->store('categories');
            $category->image = $imagePath;
        }
    
        $category->update([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'image' => $category->image, // Save the image path
        ]);
        
    if($request->parent_id != null){
        return redirect()->route('index_cat')->with('success',__('Added Successfuly'));
    }
    
        return redirect()->route('main_categories')->with('success', __('Edit Successfuly'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
