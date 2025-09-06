<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // ✅ Validate request
            $request->validate([
                'email' => 'nullable|email|required_without:username',
                'username' => 'nullable|string|required_without:email',
                'password' => 'required'
            ], [
                'email.email' => 'Email must be valid',
                'email.required_without' => 'Email or username is required',
                'username.required_without' => 'Email or username is required',
                'password.required' => 'Password is required'
            ]);

            // ✅ Determine login field
            $loginField = $request->filled('email') ? 'email' : 'username';
            $loginValue = $request->input($loginField);

            // ✅ Find user
            $user = User::where($loginField, $loginValue)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // ✅ Check if user is active
            if (!$user->isActive) {
                return response()->json([
                    'success' => false,
                    'message' => 'User account is inactive'
                ], 403);
            }

            // ✅ Create API token (Laravel Sanctum)
            $token = $user->createToken('api-token')->plainTextToken;
            $user->remember_token = $token;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            // Handle all other errors
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage() // ⚠️ Remove in production for security
            ], 500);
        }
    }
}
