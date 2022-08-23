<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
    $base64String = $request['photo'];

    /** 
     * Decode Base64 String to Image
     * Save image to public directory
     */
    $userId = $user->id;
    $fileName = $userId . '.jpg';
    $image = base64_decode($base64String);
    $directory = $userId . '/' . $fileName;
    Storage::disk('public')->put($directory, $image);

    $user->name = $request['name'];
    $user->gender = $request['gender'];
    $user->birthdate = $request['birthdate'];
    $user->body_height = $request['body_height'];
    $user->body_weight = $request['body_weight'];
    $user->blood_type = $request['blood_type'];
    $user->address = $request['address'];
    $user->phone_number = $request['phone_number'];
    $user->photo = $directory;

    $user->save();

    $response = [
      'message' => 'User updated',
      'data' => $user
    ];

    return response()->json($response, 201);
  }

  public function postUserPhoto(Request $request)
  {
    $user = $request->user();
    $base64String = $request['base64_string'];

    $fileName = $user->id . '.jpg';
    $image = base64_decode($base64String);
    Storage::disk('public')->put($user->id . '/' . $fileName, $image);
  }
}
