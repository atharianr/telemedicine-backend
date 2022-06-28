<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255|unique:users,email',
      'password' => 'required|string',
    ]);

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    $token = $user->createToken('projectToken')->plainTextToken;

    return response()->json([
      'message' => 'User Created',
      'data' => $user,
      'token' => $token
    ], 201);
  }

  public function login(Request $request)
  {
    $data = $request->validate([
      'email' => 'required|email|max:255',
      'password' => 'required|string',
    ]);

    $user = User::where('email', $data['email'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      return response()->json([
        'message' => 'Invalid Credential',
      ], 401);
    } else {
      $token = $user->createToken('mahasiswaToken')->plainTextToken;
      $response = [
        'message' => 'Login Success!',
        'data' => $user,
        'token' => $token
      ];

      return response()->json($response, 200);
    }
  }
}
