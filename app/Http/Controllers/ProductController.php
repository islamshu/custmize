<?php

// في ملف: app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Color;
use App\Models\Pen;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Str;
use File;
use DB;
class ProductController extends Controller
{
    // عرض قائمة المنتجات
    public function index()
    {
        $products = Product::with('productType')->get();
        $title = __('Products');
        return view('dashboard.products.index')->with(['products' => $products, 'title' => $title]);
    }
    public function tshirt_index()
    {
        $products = Product::with('productType')->where('product_type_id', 1)->get();
        $title = __('T-shirts');
        return view('dashboard.products.index')->with(['products' => $products, 'title' => $title]);
    }
    public function pen_index()
    {
        $products = Product::with('productType')->where('product_type_id', 2)->get();
        $title = __('Pens');
        return view('dashboard.products.index')->with(['products' => $products, 'title' => $title]);
    }


    // عرض نموذج إنشاء منتج جديد
    public function create()
    {
        $productTypes = ProductType::all();
        return view('dashboard.products.create', [
            'productTypes' => $productTypes,
            'colors' => Color::all(),
            'sizes' => Size::all(),
            'categories' => Category::whereNotNull('parent_id')->get()
        ]);
    }
    public function getSubcategories($category_id)
    {
        // Assuming you have a Subcategory model and a relation between Category and Subcategory
        $subcategories = SubCategory::where('category_id', $category_id)->get();

        // Return response in JSON format
        return response()->json($subcategories);
    }


    // تخزين منتج جديد

    public function store(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'file' => 'required', // Accept .glb or .gltf formats
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            // 'colors.*.front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'colors.*.back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'min_sale' => 'required|numeric',

        ]);


        // Handling images and saving product
        try {
            // Create new product
            $product = new Product();
            $product->slug = Str::upper(Str::random(5)) . rand(10000, 99999);
            $product->category_id = $request->category_id;
            $product->min_sale = $request->min_sale;
            $product->subcategory_id = $request->subcategory_id;
            if ($request->file != null) {
               
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
        
                // Save file to 'public/uploads' directory
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $product->image = url('/storage/' . $filePath);

            }
            $product->name = $request->name;
            $product->name_ar = $request->name_ar;
            $product->description = $request->description;
            $product->description_ar = $request->description_ar;
            $product->price = $request->price;
            if ($request->type_product != null) {
                $product->type_id = $request->type_product;
            }
            $guidness = [];
            foreach ($request->guidness as $gud) {
                $image = $gud->store('guidness');
                array_push($guidness, $image);
            }
            $product->guidness_pic = json_encode($guidness);
            $product->save();

            if ($request->has('colors_data')) {
                foreach ($request->input('colors_data') as $colorId => $colorData) {
        
                    // التحقق من وجود صورة الواجهة الأمامية وتخزينها
                    if ($request->hasFile('colors_data.' . $colorId . '.front_image')) {
                        $frontImagePath = $request->file('colors_data.' . $colorId . '.front_image')->store('colors', 'public');
                    } else {
                        $frontImagePath = null;
                    }
                    if ($request->hasFile('colors_data.' . $colorId . '.back_image')) {
                        $backImagePath = $request->file('colors_data.' . $colorId . '.back_image')->store('colors', 'public');
                    } else {
                        $backImagePath = null;
                    }
        
                    // التحقق من وجود صورة الواجهة الخلفية وتخزينها
                    if ($request->hasFile('colors_data.' . $colorId . '.right_side_image')) {
                        $rightSideImagePath = $request->file('colors_data.' . $colorId . '.right_side_image')->store('colors', 'public');
                    } else {
                        $rightSideImagePath = null;
                    }
                    if ($request->hasFile('colors_data.' . $colorId . '.left_side_image')) {
                        $ledtSideSideImagePath = $request->file('colors_data.' . $colorId . '.left_side_image')->store('colors', 'public');
                    } else {
                        $ledtSideSideImagePath = null;
                    }
        
                    // حفظ اللون مع الصور
                    $product->colors()->attach($colorId, [
                        'front_image' => $frontImagePath,
                        'back_image' => $backImagePath,
                        'right_side_image'=>$rightSideImagePath,
                        'left_side_image'=>$ledtSideSideImagePath,
                        'price' => $colorData['price'] ?? 0,
                    ]);
        
                    // حفظ الأحجام المرتبطة باللون
                    if (isset($colorData['sizes'])) {
                        foreach ($colorData['sizes'] as $sizeData) {
                            ProductSize::create([
                                'product_id' => $product->id,
                                'color_id' => $colorId,
                                'size_id' => $sizeData['id'],
                                'price' => $sizeData['price'],
                            ]);
                        }
                    }
                }
            }
            return redirect()->route('products.index')->with('success', __('Added Successfuly'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while saving the product.']);
        }
    }




    protected function storeImagesInSession(Request $request)
    {
        $colorImages = [];

        foreach ($request->colors as $index => $color) {
            if ($request->hasFile("colors.{$index}.front_image")) {
                $path = $request->file("colors.{$index}.front_image")->store('temp/colors');
                $colorImages[$index]['front_image'] = $path;
            }

            if ($request->hasFile("colors.{$index}.back_image")) {
                $path = $request->file("colors.{$index}.back_image")->store('temp/colors');
                $colorImages[$index]['back_image'] = $path;
            }
        }

        session()->put('temp_color_images', $colorImages);
    }

    protected function storeColorsAndSizes(Request $request, $product)
    {
        foreach ($request->input('colors', []) as $colorData) {
            $color = $product->colors()->create([
                'name' => $colorData['name'],
                'front_image' => $colorData['front_image'] ?? null,
                'back_image' => $colorData['back_image'] ?? null,
            ]);

            if (isset($colorData['front_image'])) {
                $color->addMediaFromRequest('front_image')->toMediaCollection('front_images');
            }

            if (isset($colorData['back_image'])) {
                $color->addMediaFromRequest('back_image')->toMediaCollection('back_images');
            }
        }

        foreach ($request->input('sizes', []) as $sizeData) {
            $product->sizes()->create($sizeData);
        }
    }

    protected function clearTempImages()
    {
        $tempImages = session()->get('temp_color_images', []);
        foreach ($tempImages as $images) {
            if (isset($images['front_image'])) {
                Storage::delete($images['front_image']);
            }
            if (isset($images['back_image'])) {
                Storage::delete($images['back_image']);
            }
        }
        session()->forget('temp_color_images');
    }


    // عرض تفاصيل منتج معين
    public function show(Product $product)
    {
        return view('dashboard.products.show', compact('product'));
    }

    // عرض نموذج تعديل منتج معين
    public function edit($id)
    {
        $product = Product::with(['colors'])->findOrFail($id);

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
    
        return view('dashboard.products.edit', compact('product', 'categories', 'colors', 'sizes'));
    }

    // تحديث منتج معين
    public function update(Request $request, $id)
    {
        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric',
            'min_sale' => 'required|numeric',
            'file' => 'nullable|file|mimes:glb,gltf',
        ]);
    
        try {
            // البحث عن المنتج
            $product = Product::findOrFail($id);
    
            // تحديث البيانات الأساسية للمنتج
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->name = $request->name;
            $product->name_ar = $request->name_ar;
            $product->description = $request->description;
            $product->description_ar = $request->description_ar;
            $product->price = $request->price;
            $product->min_sale = $request->min_sale;
            if ($request->type_product != null) {
                $product->type_id = $request->type_product;
            }
            // تحديث الملف (3D model) إذا تم رفعه
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filePath = $file->store('uploads', 'public');
                $product->image = url('/storage/' . $filePath);
            }
    
            // تحديث صور الإرشادات (guidness images)
            if ($request->guidness || $request->deleted_images) {
                $deletedImages = json_decode($request->deleted_images, true) ?? [];
                $currentImages = json_decode($product->guidness_pic, true) ?? [];
    
                $updatedImages = array_diff($currentImages, $deletedImages);
    
                if ($request->hasFile('guidness')) {
                    foreach ($request->file('guidness') as $image) {
                        $imageName = $image->store('guidness', 'public');
                        $updatedImages[] = $imageName;
                    }
                }
    
                $product->guidness_pic = json_encode(array_values($updatedImages));
            }
    
            $product->save();
    
            // تحديث الألوان
            if ($request->has('colors_data')) {
                foreach ($request->colors_data as $colorId => $colorData) {
                    // البحث عن السجل القديم للون المحدد
                    $existingColor = ProductColor::where('product_id', $product->id)
                                                 ->where('product_color_id', $colorId)
                                                 ->first();
            
                    // تحديد مسار الصور (استخدام الصورة القديمة إن لم يتم رفع صورة جديدة)
                    $frontImagePath = $existingColor ? $existingColor->front_image : null;
                    $backImagePath = $existingColor ? $existingColor->back_image : null;
                    $rightSideImagePath = $existingColor ? $existingColor->right_side_image : null;
                    $leftSideImagePath = $existingColor ? $existingColor->left_side_image : null;

                    if ($request->hasFile("colors_data.$colorId.front_image")) {
                        // رفع الصورة الأمامية الجديدة
                        $frontImagePath = $request->file("colors_data.$colorId.front_image")->store('colors', 'public');
                    }
            
                    if ($request->hasFile("colors_data.$colorId.back_image")) {
                        // رفع الصورة الخلفية الجديدة
                        $backImagePath = $request->file("colors_data.$colorId.back_image")->store('colors', 'public');
                    }
                    if ($request->hasFile("colors_data.$colorId.right_side_image")) {
                        // رفع الصورة الخلفية الجديدة
                        $rightSideImagePath = $request->file("colors_data.$colorId.right_side_image")->store('colors', 'public');
                    }
                    if ($request->hasFile("colors_data.$colorId.left_side_image")) {
                        // رفع الصورة الخلفية الجديدة
                        $leftSideImagePath = $request->file("colors_data.$colorId.left_side_image")->store('colors', 'public');
                    }
            
                    // إذا كان السجل موجودًا يتم التحديث، وإلا يتم الإضافة
                    if ($existingColor) {
                        $existingColor->update([
                            'front_image' => $frontImagePath,
                            'back_image' => $backImagePath,
                            'right_side_image' => $rightSideImagePath,
                            'left_side_image' => $leftSideImagePath,
                            'price' => $colorData['price'] ?? $existingColor->price,
                        ]);
                    } else {
                        // إضافة سجل جديد في حالة عدم وجود السجل القديم
                        $product->colors()->attach($colorId, [
                            'front_image' => $frontImagePath,
                            'back_image' => $backImagePath,
                            'right_side_image' => $rightSideImagePath,
                            'left_side_image' => $leftSideImagePath,
                            'price' => $colorData['price'] ?? 0,
                        ]);
                    }
            
                    // التعامل مع الأحجام المرتبطة باللون
                    if (isset($colorData['sizes'])) {
                        foreach ($colorData['sizes'] as $sizeData) {
                            ProductSize::updateOrCreate([
                                'product_id' => $product->id,
                                'color_id' => $colorId,
                                'size_id' => $sizeData['id'],
                            ], [
                                'price' => $sizeData['price'],
                            ]);
                        }
                    }
                }
            }
            
    
            return redirect()->route('products.index')->with('success', __('Edit Successfuly'));
        } catch (\Exception $e) {
            dd($e->getMessage()); // اظهار رسالة الخطأ للمعاينة
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while updating the product.']);
        }
    }
    
    

    // حذف منتج معين
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', __('Deleted Successfuly'));
    }
}
