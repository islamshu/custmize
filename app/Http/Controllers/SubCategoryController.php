<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTypes;
use App\Models\SubCategory;
use App\Models\TypeCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.sub_cats.index')->with('categories',SubCategory::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sub_cats.create')->with('types',TypeCategory::get())->with('subs',Category::whereNotNull('parent_id')->get());
    }
    public function get_deteitls_subcategories($id){
        $subcategories = SubCategory::find($id);

        $types = CategoryTypes::where('sub_category_id',$id)->get(['type_id']);
        $arr = [];
        foreach($types as $t){
            array_push($arr,$t->type_id);
        }
        $typess = TypeCategory::whereIn('id',$arr)->get()->toArray();
        return response()->json(['subcategorries'=>$subcategories,'types'=>$typess]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required',
           'image'=>'required',
           'category_id'=>'required',
           'attriputs.*'=>'required',
        ]);
        $subCat = new SubCategory();
        $subCat->name = $request->name;
        $subCat->image = $request->image->store('sub_categories');
        $subCat->category_id = $request->category_id;
        $subCat->attributs = json_encode($request->attriputs);
        $subCat->have_types = $request->have_types;
        $subCat->have_one_image = $request->have_one_image;
        $subCat->have_two_image = $request->have_two_image;
        
        $subCat->save();
       
        if($request->have_types != 0){
            foreach($request->types as $type ){
              $c=  new CategoryTypes();
              $c->type_id = $type;
              $c->sub_category_id = $subCat->id;
              $c->save();
            }
        }
        return redirect()->route(route: 'subcategories.index')->with('success', __('Added Successfuly'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard.sub_cats.edit')->with('sub',SubCategory::find($id))->with('types',TypeCategory::get())->with('subs',Category::whereNotNull('parent_id')->get());

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'attriputs.*'=>'required',
            'types'=>$request->have_types == 1 ? 'required':""
         ]);
         $subCat = SubCategory::find($id);
         $subCat->name = $request->name;
         if($request->image != null){
            $subCat->image = $request->image->store('sub_categories');
         }
         $subCat->category_id = $request->category_id;
         $subCat->attributs = json_encode($request->attriputs);
         $subCat->have_types = $request->have_types;
         $subCat->have_one_image = $request->have_one_image;
         $subCat->have_two_image = $request->have_two_image;
         
         $subCat->save();
        
         if($request->have_types != 0){
            CategoryTypes::where('sub_category_id',$subCat->id)->delete();
             foreach($request->types as $type ){
               $c=  new CategoryTypes();
               $c->type_id = $type;
               $c->sub_category_id = $subCat->id;
               $c->save();
             }
         }
         return redirect()->route(route: 'subcategories.index')->with('success', value: __('Edit Successfuly'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
