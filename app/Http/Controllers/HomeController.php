<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\GeneralInfo;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\TempOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function welcom(Request $request)
    {
        $products = Product::with(['favorites' => function ($query) {
            $query->where('client_id', auth()->guard('client')->id());
        }])->get();
        return view('front.index')->with('products', $products);
    }
    public function setting_my_fatoorah(){
        return view('dashboard.setting_myfatoorah');
    }
    public function update_my_fatoorah(Request $request)
    {
        // تحديد المتغيرات التي ترغب في تحديثها
        $data = [
            'MYFATOORAH_API_KEY' => $request->input('my_key'),
            'MYFATOORAH_API_URL' => $request->input('my_url'),
        ];

        // تحديث ملف .env
        foreach ($data as $key => $value) {
            $this->updateEnv($key, $value);
        }


        return redirect()->route('setting_my_fatoorah')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }

    private function updateEnv($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
    // public function cart(Request $request){
    //     $guestId = session('guest_id');

    //     // Get cart content for the guest
    //     // $cartItems = Cart::session($guestId)->getContent();
    //     // $guestId = session('guest_id');
    //     // Cart::session($guestId)->clear();
    //     // Cart::session($guestId)->remove(30);

    //     $cartItems = Cart::session($guestId)->getContent();
    //     // dd($cartItems);
    //     return view('front.cart')->with('carts',$cartItems);
    // }
    public function cart(Request $request)
    {
        // Retrieve guest_id from session or generate a new one if not present
        if (!session()->has('guest_id')) {
            // Generate a unique guest ID and store it in the session
            $guestId = uniqid('guest_', true);  // or you could use something like Str::uuid()
            session(['guest_id' => $guestId]);
        } else {
            $guestId = session('guest_id');
        }

        // Bind the cart session with the guest ID
        Cart::session($guestId);

        // Get cart content for the guest
        $carts = Cart::getContent();
        $subtotal = Cart::getSubTotal(); // Get the subtotal of the cart
        $shipping = (float)get_general_value('shipping')  == null ? 0 : (float)get_general_value('shipping');  // Static shipping fee or dynamic if required
        $tax = $subtotal * (float)get_general_value('tax')  == null ? 0 : (float)get_general_value('tax'); // 10% tax rate, you can adjust this as needed
        $total = (float)$subtotal + (float)$shipping + (float)$tax;
        // dd($shipping);
        return view('front.cart', compact('carts', 'subtotal', 'shipping', 'tax', 'total'));
        // Return the view with cart items
    }

    public function home()
    {

        return view('dashboard.index');
    }
    public function get_design()
    {
        $frontDesign = asset('uploads/tshirt_images/' . data_get(session()->get('design'), 'design.front_design'));
        $backDesign = asset('uploads/tshirt_images/' . data_get(session()->get('design'), 'design.back_design'));

        return response()->json([
            'frontDesign' => $frontDesign,
            'backDesign' => $backDesign
        ]);
    }
    public function showProduct(Request $request, $id)
    {
        // Get the product by ID
        if (!$request->session()->has('user_id')) {
            $userId = Str::uuid()->toString();
            $request->session()->put('user_id', $userId);
        }
        $pro = TempOrder::where('user_id', session()->get('user_id'))->get();
        foreach ($pro as $p) {
            $p->delete();
        }
        $product = Product::where('slug', $id)->first();

        // Get the associated colors and images from product_colors table


        // Pass data to the Blade template
        return view('front.t-shirt', compact('product'));
    }
    public function getColorImage(Request $request)
    {
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');

        // Find the image in the product_colors table
        $productColor = DB::table('product_colors')
            ->where('product_id', $productId)
            ->where('color_id', $colorId)
            ->first();

        if ($productColor) {
            return response()->json([
                'front_image' => asset('uploads/' . $productColor->front_image),
                'back_image' =>  asset('uploads/' . $productColor->back_image),
                'price' => $productColor->price
            ]);
        } else {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }
    public function confirm_order()
    {

        $product = TempOrder::where('user_id', session()->get('user_id'))->first();
        // dd($product);
        if ($product == null || $product->front_image == null) {
            return response()->json(['error' => 'حدث خطأ يرجى اعتماد تصميم الواجهات', 'code' => '404']);
        }
        $p = ProductColor::where('product_id', $product->product_id)->where('color_id', $product->color_id)->first();
        if ($product->front_image == null) {
            return response()->json([
                'name' => $product->product->name,
                'description' => $product->product->description,
                'price' => $product->product->price,
                'front_image' => asset('uploads/' . $p->front_image),
                'back_image' => asset('storage/uploads/' . $product->back_image),
            ]);
        }
        if ($product->back_image == null) {
            return response()->json([
                'name' => $product->product->name,
                'description' => $product->product->description,
                'price' => $product->product->price,
                'front_image' => asset('storage/uploads/' . $product->front_image),
                'back_image' => asset('uploads/' . $p->back_image),
            ]);
        }
        return response()->json([
            'name' => $product->product->name,
            'description' => $product->product->description,
            'price' => $product->product->price,
            'front_image' => asset('storage/uploads/' . $product->front_image),
            'back_image' => asset('storage/uploads/' . $product->back_image),
        ]);
    }

    public function addToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $color = $request->input('color');
        $size = $request->input('size');
        $price = $request->input('price');
        $qty = $request->input('qty');
        $front_image = $request->input('front_image');
        $front_design = $request->input('front_design');

        Cart::add($product_id, 'Product Name', $price, $qty, [
            'color' => $color,
            'size' => $size,
            'front_image' => $front_image,
            'front_design' => $front_design,
            // initially, don't include back_image and back_design
        ]);

        return response()->json(['message' => 'Item added to cart']);
    }
    public function updateCartItem(Request $request)
    {
        $product_id = $request->input('product_id');
        $back_image = $request->input('back_image');
        $back_design = $request->input('back_design');

        // Find the cart item
        $item = Cart::get($product_id);

        // Update the item with new back_image and back_design
        Cart::update($product_id, [
            'attributes' => array_merge($item->attributes, [
                'back_image' => $back_image,
                'back_design' => $back_design,
            ])
        ]);

        return response()->json(['message' => 'Cart item updated']);
    }
    public function removeFromCart($product_id)
    {
        Cart::remove($product_id);

        return response()->json(['message' => 'Item removed from cart']);
    }
    public function viewCart()
    {
        $carts = Cart::getContent(); // Get all cart items
        $subtotal = Cart::getSubTotal(); // Get the subtotal of the cart

        return view('cart.view', compact('carts', 'subtotal')); // Pass both the cart items and subtotal to the view
    }
    public function toggleFavorite(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false]);
        }

        // افتراض أن المستخدم مسجل الدخول
        $user = auth('client')->user();

        if ($user->favorites()->where('product_id', $id)->exists()) {
            // إزالة من المفضلة
            $user->favorites()->detach($id);
        } else {
            // إضافة إلى المفضلة
            $user->favorites()->attach($id);
        }

        return response()->json(['success' => true]);
    }


    public function saveDesign(Request $request)
    {
        $shirtImageData = $request->input('shirt_image');
        $designImageData = $request->input('designImageData');

        // Process and save the shirt image

        $shirtImage = str_replace('data:image/png;base64,', '', $shirtImageData);
        $shirtImage = str_replace(' ', '+', $shirtImage);
        $shirtImageName = 'shirt_' . time() . '.png';
        $shirtImagePath = 'uploads/tshirt_images' . $shirtImageName;
        Storage::disk('public')->put($shirtImagePath, base64_decode($shirtImage));

        // Process and save the design image
        $designImage = str_replace('data:image/png;base64,', '', $designImageData);
        $designImage = str_replace(' ', '+', $designImage);
        $designImageName = 'design_' . time() . '.png';
        $designImagePath = 'uploads/tshirt_images'  . $designImageName;
        Storage::disk('public')->put($designImagePath, base64_decode($designImage));


        $userid =  session()->get('user_id');

        $temp = TempOrder::where('user_id', $userid)->first();
        if (!$temp) {

            $temp = new TempOrder();
            $temp->user_id = $userid;
        }
        $temp->color_id = $request->selectedColorId;
        $temp->product_id = $request->productId;
        if ($request->selectedSide == 'front') {
            Storage::disk('public')->delete('uploads/tshirt_images' . $temp->front_image);
            Storage::disk('public')->delete('uploads/tshirt_images' . $temp->design_front);
            $temp->front_image = $shirtImageName;
            $temp->design_front = $designImageName;
        } else {
            Storage::disk('public')->delete('uploads/tshirt_images' . $temp->back_image);
            Storage::disk('public')->delete('uploads/tshirt_images' . $temp->design_back);
            $temp->back_image = $shirtImageName;
            $temp->design_back = $designImageName;
        }
        $temp->save();

        return response()->json([
            'success' => true,
        ]);
    }
    public function saveDesign_new(Request $request)
    {

        \Log::info('Received request to save shirt');
        \Log::info('Request data:', $request->all());

        try {
            // التحقق من وجود البيانات المطلوبة
            $request->validate([
                'shirtImage' => 'required',
                'selectedSide' => 'required',
                'productId' => 'required',
                'selectedColorId' => 'required',
            ]);

            // معالجة البيانات هنا
            // ...

            return response()->json(['message' => 'Shirt saved successfully']);
        } catch (\Exception $e) {
            \Log::error('Error saving shirt: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save shirt'], 500);
        }
    }
    public function get_design_preview()
    {
        $userid =  session()->get('user_id');
        $temp = TempOrder::where('user_id', $userid)->first();
        $frontDesign = $temp->front_image;
        $backDesign = $temp->back_image;

        return response()->json([
            'front_shirt_image' => asset('uploads/' . $temp->product->colors->where('color_id', $temp->color_id)->first()->front_image),
            'back_shirt_image' => asset('uploads/' . $temp->product->colors->where('color_id', $temp->color_id)->first()->back_image),
            'front_design_image' => $frontDesign ? asset('uploads/tshirt_images/' . $frontDesign) : asset('uploads/' . $temp->product->colors->where('color_id', $temp->color_id)->first()->front_image),
            'back_design_image' => $backDesign ? asset('uploads/tshirt_images/' . $backDesign) : asset('uploads/' . $temp->product->colors->where('color_id', $temp->color_id)->first()->back_image),
        ]);
    }

    public function get_image_session()
    {
        $fornt = session()->get('front_design');
        $back = session()->get('back_design');
        return response()->json([
            'front' => asset('uploads/' . $fornt),
            'back' => asset('uploads/' . $back),
        ]);
    }


    public function getShirts()
    {
        $shirts = Product::with('colors')->get();
        // Return the shirts and colors data in the correct format for the frontend
        $response = [];

        foreach ($shirts as $shirt) {
            $colors = [];
            foreach ($shirt->colors as $colorr) {
                $color = $colorr->color;
                $colors[] = [
                    'id' => $color->id,
                    'filename' => $color->name,
                    'color' => $color->code
                ];
            }

            $response[$shirt->id] = [
                'filename' => $shirt->name,
                'color' => $colors
            ];
        }

        return response()->json($response);
    }
    public function saveShirtImage(Request $request)
    {
        $shirtImageData = $request->input('shirt_image');
        $designImageData = $request->input('design_image');

        // Process and save the shirt image
        if ($request->shirt_image) {


            $shirtImage = str_replace('data:image/png;base64,', '', $shirtImageData);
            $shirtImage = str_replace(' ', '+', $shirtImage);
            $shirtImageName = 'shirt_' . time() . '.png';
            $shirtImagePath = 'uploads/' . $shirtImageName;
            Storage::disk('public')->put($shirtImagePath, base64_decode($shirtImage));
        }
        if ($request->design_image) {
            // Process and save the design image
            $designImage = str_replace('data:image/png;base64,', '', $designImageData);
            $designImage = str_replace(' ', '+', $designImage);
            $designImageName = 'design_' . time() . '.png';
            $designImagePath = 'uploads/'  . $designImageName;
            Storage::disk('public')->put($designImagePath, base64_decode($designImage));
        }

        if (!session()->has('guest_id')) {
            session(['guest_id' => uniqid('guest_', true)]);
        }
        $guestId = session('guest_id');
        // Cart::session($guestId)->update($request->product_id, [
        //     'quantity' => [
        //         'relative' => false,
        //         'value' => $request->quantity,
        //     ],
        // ]);
        $productId = $request->product_id;
        $cart =  Cart::session($guestId)->add([
            'id' => $request->product_id,
            'name' => 'Product Name', // Retrieve this from your product model
            'price' => $request->price, // Set product price dynamically
            'quantity' => $request->qty,
            'attributes' => [
                'color' => $request->selectedColorId,
                'size' => $request->sizeName,
            ],

        ]);





        $cartItem = Cart::session($guestId)->get($productId);
        $cartColor = $cartItem->attributes->color; // If color is stored as an attribute

        if ($cartItem && $cartColor != $request->selectedColorId) {

            $qq = 'true';


            if ($request->selectedSide == 'front') {
                Cart::session($guestId)->update($productId, [
                    'back_image' => null,
                    'back_design' => null,
                    'quantity' => [
                        'relative' => false,
                        'value' => $request->qty,
                    ],
                ]);
            } else {
                Cart::session($guestId)->update($productId, [
                    'front_image' => null,
                    'front_design' => null,
                    'quantity' => [
                        'relative' => false,
                        'value' => $request->qty,
                    ],
                ]);
            }
        } else {
            $qq = 'false';
        }

        if ($request->selectedSide == 'front') {
            Storage::disk('public')->delete('uploads/' . $cartItem->front_image);
            Storage::disk('public')->delete('uploads/' . $cartItem->front_design);
            Cart::session($guestId)->update($productId, [
                'front_image' => $shirtImageName,
                'front_design' => $designImageName,
                'quantity' => [
                    'relative' => false,
                    'value' => $request->qty,
                ],                    // Add any other attributes you want to update

            ]);
            $message = 'تم حفظ التصميم الامامي بنجاح';
        } else {
            Storage::disk('public')->delete('uploads/' . $cartItem->back_image);
            Storage::disk('public')->delete('uploads/' . $cartItem->back_design);
            Cart::session($guestId)->update($productId, [
                'back_image' => $shirtImageName,
                'back_design' => $designImageName,
                'quantity' => [
                    'relative' => false,
                    'value' => $request->qty,
                ],                // Add any other attributes you want to update

            ]);
            $message = 'تم حفظ التصميم الخلفي بنجاح';
        }

        if ($qq == 'true') {
            return response()->json(['success' => true, 'danger' => 'warning', 'message' => 'تم حفظ التصميم ولكن يرجى اعادة اعتمادة الواجهة الاخرى بسبب قيامك بتغير اللون']);
        } else {
            return response()->json(['success' => true, 'message' => $message]);
        }

        // Optionally, save the image path to the database
        // Assuming you have a Shirt model with an 'image_path' field


        // return response()->json(['success' => true, 'message' => 'Image saved successfully']);
    }
    public function updateCart(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Get guest ID
        $guestId = session('guest_id');

        // Update the quantity of the product in the cart
        Cart::session($guestId)->update($request->product_id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity,
            ],
        ]);

        // Retrieve the updated cart item
        $cartItem = Cart::session($guestId)->get($request->product_id);

        if ($cartItem) {
            // Calculate new totals
            $subtotal = Cart::session($guestId)->getSubTotal();
            $shipping = (float)(get_general_value('shipping') == null ? 0 : get_general_value('shipping')); // Fixed shipping cost
            $tax = (float)$subtotal * (float)(get_general_value('tax') == null ? 0 : get_general_value('tax')); // Assuming a 10% tax rate
            $total = $subtotal + $shipping + $tax;

            // Prepare the response data
            return response()->json([
                'message' => 'Cart updated successfully!',
                'item_total' => $cartItem->getPriceSum(), // Updated item total
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
            ]);
        } else {
            return response()->json([
                'error' => 'Product not found in cart.',
            ], 404); // Not found status code
        }
    }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string',
        ]);

        $coupon = $request->input('coupon');
        $discountCode = DiscountCode::where('code', $coupon)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->first();

        if (!$discountCode) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired promo code.']);
        }
        $guestId = session('guest_id');

        Cart::session($guestId);

        // Get cart content for the guest
        $carts = Cart::getContent();
        $subtotal = Cart::getSubTotal(); // Get the subtotal of the cart
        $shipping = (float)get_general_value('shipping')  == null ? 0 : (float)get_general_value('shipping');  // Static shipping fee or dynamic if required
        $tax = $subtotal * (float)get_general_value('tax')  == null ? 0 : (float)get_general_value('tax'); // 10% tax rate, you can adjust this as needed
        $total = (float)$subtotal + (float)$shipping + (float)$tax;
        $discountValue = $discountCode->discount_value;
        $discountType = $discountCode->discount_type;

        // dd(vars: $total);
        // Initialize total with the current subtotal
        if ($discountType === 'fixed') {
            // Apply fixed discount
            $discountAmount = min($discountValue, $total); // Ensure we don't discount more than the total
            $total = max(0, $total - $discountAmount);
        } elseif ($discountType === 'rate') {
            // Apply percentage discount
            $discountAmount = $subtotal * ($discountValue / 100); // Calculate the discount amount based on the percentage
            $total = max(0, $total - $discountAmount);
        }

        // Calculate additional costs (shipping, tax, etc.)

        // Final total calculation
        $finalTotal = $total + $shipping + $tax;

        return response()->json([
            'success' => true,
            'message' => 'Promo code applied successfully!',
            'subtotal' => $total,
            'shipping' => $shipping,
            'tax' => $tax,
            'discount' =>  (float)$discountAmount, // Include the discount amount
            'total' => $finalTotal,
        ]);
    }

    public function removeCart(Request $request)
    {
        // dd($request->all());
        $guestId = session('guest_id');
        Cart::session($guestId)->remove($request->productid);

        return response()->json(['message' => 'Item removed from cart!']);
    }
    public function checkCart(Request $request)
    {
        // Retrieve guest_id from session
        if (!session()->has('guest_id')) {
            return response()->json(['cartEmpty' => true, 'message' => 'Session key is required.', 'error' => 'yes'], 200);
        }

        $guestId = session('guest_id');

        // Now check the cart based on the session id
        $cart = Cart::session($guestId);

        // Check if the cart has items
        if ($cart->isEmpty()) {
            return response()->json(['cartEmpty' => true, 'message' => 'Your cart is empty.'], 200);
        }
    }

    public function check_temp()
    {
        $userid =  session()->get('user_id');
        if ($userid != null) {
            $temp = TempOrder::where('user_id', $userid)->first();
            if ($temp) {

                return response()->json(['success' => true, 'message' => 'بسبب قيامك بتغير اللون 
                يرجى اعادة اعتمادة التصميم للواجهة الاخرى ']);
            }
        }
    }
    public function change_lang($lang)
    {
        Session::put('lang', $lang);
        return redirect()->back();
    }
    public function show_translate($lang)
    {
        $language = $lang;

        return view('dashboard.languages.language_view_en', compact('language'));
    }
    public function key_value_store(Request $request)
    {
        $data = openJSONFile($request->id);
        foreach ($request->key as $key => $key) {
            $data[$key] = $request->key[$key];
        }
        saveJSONFile($request->id, $data);
        return back();
    }
    public function login()
    {
        if (auth()->check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }
    public function client_login()
    {
        if (auth()->check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }



    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['error' => trans('Email Or Password not correct')]);
    }
    public function setting()
    {
        return view('dashboard.setting');
    }
    public function shopping()
    {
        return view('dashboard.shopping');
    }

    public function add_general(Request $request)
    {
        // dd($request);
        if ($request->hasFile('general_file')) {
            foreach ($request->file('general_file') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value->store('general'));
            }
        }
        if ($request->has('general')) {

            foreach ($request->input('general') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value);
            }
        }

        return redirect()->back()->with(['success' => trans('Edit Successfuly')]);
    }
    public function edit_profile()
    {
        return view('dashboard.edit_profile');
    }
    public function edit_profile_post(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        if ($request->password != null) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => 'false'], 422);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        if ($request->image != null) {
            $user->image = $request->image->store('/users');
        }
        $user->save();
        return response()->json(['success' => 'true'], 200);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
}
