<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerUser(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'username' => ['required', 'string', 'max:25', 'alpha_dash', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:50', 'confirmed']
        ]);

        $user = User::create([
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'])
        ]);

        Auth::guard('user')->attempt([
            'username' => $userData['username'],
            'password' => $userData['password']
        ]);
    
        return response()->json(['message' => 'Registration successful.', 'user' => $user], 201);
    }

    /**
     * Check authentication status for user and admin guards.
     *
     * @return array
     */
    public function checkAuthentication(Request $request) {
       
        $data = [
            'user' => Auth::guard('user')->check(),
            'adminUser' => Auth::guard('admin')->check()
        ];

        return response()->json($data, 200);
    }

    /**
     * Log in a user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($user = Auth::guard('user')->attempt($credentials)) {
            $request->session()->put('user', $user);
            return response()->json(['user' => Auth::guard('user')->user()], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    /**
     * Log in an admin user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */    
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['adminUser' => Auth::guard('admin')->user()], 200);
        }
    
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Log out a user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLogout()
    {
        Auth::guard('user')->logout();    
        return response()->json(['message' => 'User logged out'], 200);
    }

    /**
     * Log out an admin user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
        public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return response()->json(['message' => 'Admin logged out'], 200);
    }
}