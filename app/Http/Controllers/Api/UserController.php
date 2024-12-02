<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAuthResource;
use App\Http\Resources\UserResource;
use App\Mail\PasswordResetMail;
use App\Mail\VerifyEmail;
use App\Mail\WelcomRgister;
use App\Models\Client;
use Illuminate\Http\Request;
use Validator;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;
use Crypt;
use Illuminate\Support\Str;

class UserController extends BaseController
{

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = Client::where('email', $request->email)->first();
        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $res = new UserAuthResource($user);
                return $this->sendResponse($res, 'تم تسجيل الدخول بنجاح');
            } else {
                $res = 'كلمة المرور غير صحيحة';
                return $this->sendError($res);
            }
        } else {
            $res = 'لم يتم العثور على المستخدم';
            return $this->sendError($res);
        }
    }
    public function verify_otp(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = Client::where('otp', $request->otp)->first();
        if ($user) {

            $user->otp = null;
            $user->email_verified_at = now();
            $user->save();
            $baseUrl = url('/');
            return $this->sendResponse(new UserResource($user), __('Verified Successfuly'));
            return redirect($baseUrl);
        } else {
            $res = __('The verification code is incorrect. Please try again.');
            return $this->sendError($res);
        }
    }
    public function forgotPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:clients,email',
        ]);

        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }

        $client = Client::where('email', $request->email)->first();

        // Generate a password reset token
        do {
            $otp = random_int(100000, 999999);
        } while (Client::where('otp', $otp)->exists());

        $client->otp = $otp;
        $client->save();
        // Send a password reset link to the user's email
        Mail::to($client->email)->send(new PasswordResetMail($client, $otp));

        return $this->sendResponse('send success the otp'. $otp, __('Password reset link sent successfully'));
    }
    public function resetPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'otp' => 'required|numeric',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }

        $client = Client::where('otp', $request->otp)->first();

        if (!$client) {
            return $this->sendError(__('Invalid OTP'));
        }

        $client->password = bcrypt($request->password);
        $client->otp = null;
        $client->save();

        $res = new UserResource($client);
        return $this->sendResponse($res, __('Password Updated succseffuly'));
    }
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = Client::where('email', $request->email)->first();
        if ($user) {
            return $this->sendError(__('Email already exists'));
        }
        $user = new Client();
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        do {
            $otp = random_int(100000, 999999);
        } while (Client::where('otp', $otp)->exists());

        $user->otp = $otp;
        $user->save();
        Mail::to($user->email)->send(new WelcomRgister($user->name, $user->email));
        $enc = encrypt($user->id);
        $url = route('send_email.verfy', $enc);
        Mail::to($request->email)->send(new VerifyEmail($otp));
        $res = new UserResource($user);
        return $this->sendResponse($res, __('Register Successfuly Please confrim your email'));
    }
    public function myprofile()
    {
        $user = auth('api')->user();
        return $this->sendResponse(new UserResource($user), __('User Profile'));
    }
    public function update_profile(Request $request)
    {

        $user = auth('api')->user();

        // Validation rules
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|string|in:male,female',
            'DOB' => 'nullable|date',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validation->messages()->all());
        }

        // Update user information
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'DOB' => $request->DOB,
            'state' => $request->state,
            'country' => $request->country,
        ]);

        return $this->sendResponse(new UserResource($user), __('User Profile'));
    }
}
