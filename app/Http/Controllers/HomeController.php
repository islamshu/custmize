<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use App\Models\Product;
use App\Models\TempOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function welcom(Request $request){
      
            if (!$request->session()->has('user_id')) {
                $userId = Str::uuid()->toString();
                $request->session()->put('user_id', $userId);
            }
    
        Session::forget('design');
        return view('welcome');
    }
    public function home(){
        return view('dashboard.index');
    }
    public function get_design(){
        $frontDesign = asset('uploads/tshirt_images/'.data_get(session()->get('design'), 'design.front_design'));
        $backDesign = asset('uploads/tshirt_images/'.data_get(session()->get('design'), 'design.back_design'));

        return response()->json([
            'frontDesign' => $frontDesign,
            'backDesign' => $backDesign
        ]);
    }
    public function showProduct(Request $request,$id)
{
    // Get the product by ID
    if (!$request->session()->has('user_id')) {
        $userId = Str::uuid()->toString();
        $request->session()->put('user_id', $userId);
    }
    $pro = TempOrder::where('user_id',session()->get('user_id'))->get();
    foreach($pro as $p){
        $p->delete();
    }
    $product = Product::where('slug',$id)->first();

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
            'front_image' => asset('uploads/'.$productColor->front_image),
            'back_image' =>  asset('uploads/'.$productColor->back_image),
        ]);    } else {
        return response()->json(['error' => 'Image not found'], 404);
    }
}

public function saveDesign(Request $request)
{
    if($request->image){
        $image = $request->image[0];
    
        $imageName = 'design_' . Str::random(10) . '.png';
        
        // Decode the base64 image
        $imageData = base64_decode($image);
        
        // Save the image to the public folder
        $path = public_path('uploads/tshirt_images/' . $imageName);
        file_put_contents($path, $imageData);
    }else{
        $imageName = null;
    }
    
    $userid =  session()->get('user_id');
    
    $temp = TempOrder::where('user_id',$userid)->first();
    if(!$temp){
        $temp = new TempOrder();
        $temp->user_id = $userid;
    }
    $temp->color_id = $request->selectedColorId;
    $temp->product_id = $request->productId;


    if($request->selectedSide == 'front'){
        Storage::disk('public')->exists('uploads/tshirt_images' . $temp->front_image);
        $temp->front_image = $imageName;
    }else{
        Storage::disk('public')->exists('uploads/tshirt_images' . $temp->back_image);

        $temp->back_image = $imageName;
    }
    $temp->save();

    return response()->json([
        'success' => true,
    ]);
}
public function saveDesign_new(Request $request){

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
public function get_design_preview(){
    $userid =  session()->get('user_id');
    $temp = TempOrder::where('user_id',$userid)->first();
    $frontDesign = $temp->front_image;
    $backDesign = $temp->back_image;

    return response()->json([
        'front_shirt_image' =>asset('uploads/'.$temp->product->colors->where('color_id',$temp->color_id)->first()->front_image),
        'back_shirt_image' => asset('uploads/'.$temp->product->colors->where('color_id',$temp->color_id)->first()->back_image),
        'front_design_image' => $frontDesign ? asset('uploads/tshirt_images/'.$frontDesign) : asset('uploads/'.$temp->product->colors->where('color_id',$temp->color_id)->first()->front_image),
        'back_design_image' => $backDesign ? asset('uploads/tshirt_images/'.$backDesign) : asset('uploads/'.$temp->product->colors->where('color_id',$temp->color_id)->first()->back_image),
    ]);
}

public function get_image_session()
{
   $fornt= session()->get('front_design');
    $back = session()->get('back_design');
    return response()->json([
        'front' => asset('uploads/'.$fornt),
        'back' => asset('uploads/'.$back),
    ]);

    
}


    public function getShirts(){
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
    public function change_lang($lang){
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
    public function login(){
        if(auth()->check() == true){
            return redirect()->route('dashboard');
        }else{
            return view('auth.login');
        }
        
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
    public function post_login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['error'=>trans('Email Or Password not correct')]);

    }
    public function setting(){
        return view('dashboard.setting');
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
    public function edit_profile(){
        return view('dashboard.edit_profile');
    }
    public function edit_profile_post(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'email'=>'required|email|unique:users,email,'.$id,
        ]);
        if($request->password != null){
            $validator = Validator::make($request->all(), [
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password',
        ]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'success'=>'false'], 422);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != null){
            $user->password = bcrypt($request->password) ;
        }
  
        if($request->image != null){
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
