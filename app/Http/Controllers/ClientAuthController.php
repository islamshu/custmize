<?php

// app/Http/Controllers/ClientAuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('front.login');
    }
    public function showRegisterForm()
    {
        return view('front.register');
    }

 
    
        public function register(Request $request)
        {
            // تحقق من صحة البيانات
            $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
    
            // إنشاء حساب المستخدم الجديد
            $client = new Client();
            $client->first_name = $request->firstname;
            $client->last_name = $request->lastname;
            $client->email = $request->email;
            $client->password = bcrypt($request->password); // تشفير كلمة المرور
            $client->save();
    
            // تسجيل الدخول تلقائيًا بعد التسجيل
            Auth::guard('client')->login($client);
    
            // إعادة استجابة Ajax بنجاح
            return response()->json(['success' => true]);
        }
    
    
    

        public function login(Request $request)
        {
            // تحقق من صحة المدخلات
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if (Auth::guard('client')->attempt($request->only('email', 'password'))) {
                return response()->json(['success' => true, 'redirect' => route('client.dashboard')]);
            }
        
    
            // تسجيل الدخول فشل
            return response()->json(['success' => false, 'message' => 'البيانات المدخلة غير صحيحة.'], 401);
        }
        

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login');
    }
}
