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

        // dd($request->all());
        $validatedData = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'image' =>'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'colors.*.front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors.*.back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $product->image = $request->file('image')->store('models');
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

            if ($request->colors != null) {
                foreach ($request->colors as $colorId => $colorData) {

                    if (!is_array($colorData)) {
                        continue;
                    }
                    if (isset($colorData['id'], $colorData['price'], $colorData['front_image'])) {




                        $color = new ProductColor();
                        $color->product_id = $product->id;
                        $color->color_id = $colorId;
                        $color->price = $colorData['price'];
                        if ($request->hasFile("colors.$colorId.front_image") == false) {
                            continue;
                        }
                        if (isset($colorData['front_image']) && $request->hasFile("colors.$colorId.front_image")) {
                            // $frontImageName = time() . '_front_' . $request->file("colors.$colorId.front_image")->getClientOriginalName();
                            // $frontImagePath = $request->file("colors.$colorId.front_image")->storeAs('products', $frontImageName, 'public');
                            $color->front_image = $request->file("colors.$colorId.front_image")->store('products');
                        }

                        if (isset($colorData['back_image']) && $request->hasFile("colors.$colorId.back_image")) {
                            // $backImageName = time() . '_back_' . $request->file("colors.$colorId.back_image")->getClientOriginalName();
                            // $backImagePath = $request->file("colors.$colorId.back_image")->storeAs('products', $backImageName, 'public');
                            $color->back_image = $request->file("colors.$colorId.back_image")->store('products');
                        }

                        $color->save();
                    }
                }
            }
            if ($request->has('sizes')) {

                foreach ($request->sizes as $size_id) {
                    if (!is_array($size_id)) {
                        continue;
                    }

                    $size = new ProductSize();
                    $size->product_id = $product->id;
                    $size->size_name = $size_id['name'];
                    $size->price = $size_id['price'];
                    $size->save();
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
        $product = Product::find($id);
        $productTypes = ProductType::all();
        return view('dashboard.products.edit', [
            'product' => $product,
            'colors' => Color::all(),
            'sizes' => Size::all(),
            'categories' => Category::whereNotNull('parent_id')->get()
        ]);
    }

    // تحديث منتج معين
    public function update(Request $request, $id)
    {
        // Validation rules
        $validatedData = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            // 'image'=>'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'colors.*.front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors.*.back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'min_sale'=>'required|numeric'
        ]);

        // Fetch the existing product
        $product = Product::findOrFail($id);

        // Handling images and saving product
        try {
            // Create new product

            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->min_sale = $request->min_sale;
            if ($request->image != null) {
                $file = $request->file('image');

                // Retain the original name and extension
                $originalName = $file->getClientOriginalName();
        
                // Store the file in the 'models' directory
                $filePath = $file->storeAs('models', $originalName, 'public');
        
                // Generate public URL
                $url = Storage::url($filePath);
                $product->image = $url;
            }
            $product->name = $request->name;
            $product->name_ar = $request->name_ar;
            $product->description = $request->description;
            $product->description_ar = $request->description_ar;
            $product->price = $request->price;
            if ($request->type_product != null) {
                $product->type_id = $request->type_product;
            }

            if ($request->guidness || $request->deleted_images) {
                $deletedImages = json_decode($request->deleted_images);
                if ($deletedImages) {
                    foreach ($deletedImages as $imageName) {
                        // حذف الصورة من السيرفر
                        $imagePath = public_path('uploads/' . $imageName);
                        if (File::exists($imagePath)) {
                            File::delete($imagePath);
                        }
                    }
                } else {
                    $deletedImages = [];
                }
                // تحديث قائمة الصور في قاعدة البيانات
                $currentImages = json_decode($product->guidness_pic);
                $updatedImages = array_diff($currentImages, $deletedImages); // إزالة الصور المحذوفة
                if ($request->hasFile('guidness')) {
                    $images = $request->file('guidness');
                    foreach ($images as $image) {
                        $imageName = time() . '-' . $image->getClientOriginalName(); // Create a unique name for the image
                        $image->move(public_path('uploads'), $imageName); // Move the image to the upload folder

                        $updatedImages[] = $imageName; // Add the new image to the updated list
                    }
                }

                // Store the updated list of images back in the database
                $product->guidness_pic = json_encode(array_values($updatedImages));
            }
            $product->save();
            if ($request->colors != null) {
                foreach ($request->colors as $colorId => $colorData) {
                    // تأكد من أن البيانات عبارة عن مصفوفة
                    if (!is_array($colorData)) {
                        continue; // تجاهل هذا العنصر إذا لم يكن مصفوفة
                    }
                    
                    // تحقق مما إذا كان اللون موجود مسبقًا
                    $existingColor = ProductColor::where('product_id', $product->id)->where('color_id', $colorId)->first();
                    
                    if ($existingColor) {
                        // تعديل البيانات للألوان الموجودة
                        if (isset($colorData['price'])) {
                            $existingColor->price = $colorData['price'];
                        }
                        
                        if (isset($colorData['front_image']) && $request->hasFile("colors.$colorId.front_image")) {
                            // معالجة الصورة الأمامية
                            $existingColor->front_image = $request->file("colors.$colorId.front_image")->store('products');
                        }
            
                        if (isset($colorData['back_image']) && $request->hasFile("colors.$colorId.back_image")) {
                            // معالجة الصورة الخلفية
                            $existingColor->back_image = $request->file("colors.$colorId.back_image")->store('products');
                        }
            
                        $existingColor->save();
                    } else {
                        // إضافة لون جديد
                        $newColor = new ProductColor();
                        $newColor->product_id = $product->id;
                        $newColor->color_id = $colorId;
            
                        if (isset($colorData['price'])) {
                            $newColor->price = $colorData['price'];
                        }
            
                        if (isset($colorData['front_image']) && $request->hasFile("colors.$colorId.front_image")) {
                            // معالجة الصورة الأمامية
                            $newColor->front_image = $request->file("colors.$colorId.front_image")->store('products');
                        }
            
                        if (isset($colorData['back_image']) && $request->hasFile("colors.$colorId.back_image")) {
                            // معالجة الصورة الخلفية
                            $newColor->back_image = $request->file("colors.$colorId.back_image")->store('products');
                        }
            
                        $newColor->save();
                    }
                }
            }
            
            // if ($request->colors != null) {
            //     foreach ($request->colors as $coo => $colorDataa) {
            //         if (isset($colorDataa['id'], $colorDataa['price'], $colorDataa['front_image'])) {
            //             $coo = ProductColor::where('product_id', $product->id)->delete();
            //         }
            //         if (isset($colorDataa['id'], $colorDataa['price'], $colorDataa['old_front_image'])) {
            //             $coo = ProductColor::where('product_id', $product->id)->delete();
            //         }
            //     }

            //     foreach ($request->colors as $colorId => $colorData) {
            //         // dd($request->all());
            //         if (!is_array($colorData)) {
            //             continue;
            //         }
            //         if (isset($colorData['id'], $colorData['price'], $colorData['front_image'])) {
            //             $color = new ProductColor();
            //             $color->product_id = $product->id;
            //             $color->color_id = $colorId;
            //             $color->price = $colorData['price'];
            //             if ($request->hasFile("colors.$colorId.front_image") == false) {
            //                 continue;
            //             }
            //             if (isset($colorData['front_image']) && $request->hasFile("colors.$colorId.front_image")) {
            //                 // $frontImageName = time() . '_front_' . $request->file("colors.$colorId.front_image")->getClientOriginalName();
            //                 // $frontImagePath = $request->file("colors.$colorId.front_image")->storeAs('products', $frontImageName, 'public');
            //                 $color->front_image = $request->file("colors.$colorId.front_image")->store('products');
            //             }

            //             if (isset($colorData['back_image']) && $request->hasFile("colors.$colorId.back_image")) {
            //                 // $backImageName = time() . '_back_' . $request->file("colors.$colorId.back_image")->getClientOriginalName();
            //                 // $backImagePath = $request->file("colors.$colorId.back_image")->storeAs('products', $backImageName, 'public');
            //                 $color->back_image = $request->file("colors.$colorId.back_image")->store('products');
            //             }

            //             $color->save();
            //         }
            //         if (isset($colorData['id'], $colorData['price'], $colorData['old_front_image'])) {
            //         }


            //         $color = new ProductColor();
            //         $color->product_id = $product->id;
            //         $color->color_id = $colorId;
            //         $color->price = $colorData['price'];

            //         if (isset($colorData['old_front_image'])) {
            //             // $frontImageName = time() . '_front_' . $request->file("colors.$colorId.front_image")->getClientOriginalName();
            //             // $frontImagePath = $request->file("colors.$colorId.front_image")->storeAs('products', $frontImageName, 'public');

            //             $color->front_image = $colorData['old_front_image'];
            //         }

            //         if (isset($colorData['old_back_image'])) {

            //             // $backImageName = time() . '_back_' . $request->file("colors.$colorId.back_image")->getClientOriginalName();
            //             // $backImagePath = $request->file("colors.$colorId.back_image")->storeAs('products', $backImageName, 'public');
            //             if (isset($colorData['old_back_image']) && $request->hasFile("colors.$colorId.back_image")) {
            //                 // $backImageName = time() . '_back_' . $request->file("colors.$colorId.back_image")->getClientOriginalName();
            //                 // $backImagePath = $request->file("colors.$colorId.back_image")->storeAs('products', $backImageName, 'public');
            //                 $color->back_image = $request->file("colors.$colorId.back_image")->store('products');

            //                 $color->back_image = $colorData['old_back_image'];
            //             }

            //             $color->save();
            //         }
            //     }
            // }
            if ($request->has('sizes')) {
                $coo = ProductSize::where('product_id', $product->id)->delete();

                foreach ($request->sizes as $size_id) {
                    if (!is_array($size_id)) {
                        continue;
                    }

                    $size = new ProductSize();
                    $size->product_id = $product->id;
                    $size->size_name = $size_id['name'];
                    $size->price = $size_id['price'];
                    $size->save();
                }
            }
            return redirect()->route('products.index')->with('success', __('Edit Successfuly'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while saving the product.']);
        }
    }

    // حذف منتج معين
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', __('Deleted Successfuly'));
    }
}
