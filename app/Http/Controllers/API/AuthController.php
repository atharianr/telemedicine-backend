<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request) {
    try {
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
        'code' => 201,
        'message' => 'User Created',
        'data' => $user,
        'token' => $token
      ], 201);
    } catch (Exception $error) {
      return response()->json([
        'code' => 400,
        'message' => $error->getMessage()
      ], 400);
    }
  }
}