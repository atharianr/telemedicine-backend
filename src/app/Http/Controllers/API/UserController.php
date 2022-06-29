<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function getUser(Request $request)
  {
    $user = $request->user();

    $response = [
      'message' => 'User fetched',
      'data' => $user
    ];

    return response()->json($response, 201);
  }

  public function editUser(Request $request)
  {
    $user = $request->user();

    $user->name = $request['name'];
    $user->gender = $request['gender'];
    $user->birthdate = $request['birthdate'];
    $user->body_height = $request['body_height'];
    $user->body_weight = $request['body_weight'];
    $user->blood_type = $request['blood_type'];
    $user->address = $request['address'];
    $user->phone_number = $request['phone_number'];


    $user->save();

    $response = [
      'message' => 'User updated',
      'data' => $user
    ];

    return response()->json($response, 201);
  }
}
