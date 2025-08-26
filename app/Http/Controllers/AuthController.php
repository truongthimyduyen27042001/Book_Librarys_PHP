<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        \Log::info('Register endpoint called', [
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);
        
        $validated = $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|unique:users',
          'password' => 'required|string|min:8',
        ]);
        
        \Log::info('Validation passed', ['email' => $validated['email']]);
        
        $user = User::create([
          'name' => $validated['name'],
          'email' => $validated['email'],
          'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        \Log::info('User created successfully', ['user_id' => $user->id]);

        return response()->json([
          'user' => $user,
          'token' => $token,
        ], 201);
    }

    public function login(Request $request) {
      $validated = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
      ]);

      if (!Auth::attempt($validated)) {
        throw ValidationException::withMessages([
          'email' => ['The provided credentials are incorrect.'],
        ]);
      }

      $user = User::where('email', $validated['email'])->first();
      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
        'user' => $user,
        'token' => $token,
      ]);
    }

    public function logout(Request $request) {
      $request->user()->currentAccessToken()->delete();
      return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request) {
      return response()->json($request->user());
    }
}