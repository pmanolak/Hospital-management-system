<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
     
    public function register(UserRegisterRequest $request)
    {
        $inputRole = strtolower($request->input('role'));
        $allowedRoles = ['admin', 'doctor', 'patient', 'receptionist', 'pharmacist'];
        if (!in_array($inputRole, $allowedRoles)) {
            return response()->json(['error' => 'Invalid role provided'], 422);
        }
        $role = ucfirst($inputRole);  
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole($role);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'user'    => $user,
            'token'   => $token,
            'message' => 'User registered successfully.'
        ]);
    }

     
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid email or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json([
            'token' => $token,
            'user'  => auth()->user(),
        ]);
    }

     
    public function profile()
    {
        return response()->json(auth()->user());
    }

     
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }
}
