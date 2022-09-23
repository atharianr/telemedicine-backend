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
     **/
    $userId = $user->id;
    $fileName = $userId . '.jpg';
    $directory = $userId . '/' . $fileName;
    if ($base64String  == "" || $base64String == null || $base64String == "null") {
      Storage::disk('public')->delete($directory);
      $directory = null;
    } elseif ($base64String  == "there_is_image") {
      
    } else {
      $image = base64_decode($base64String);
      Storage::disk('public')->put($directory, $image);
    }

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

  public function putTokenFCM(Request $request)
  {
    $user = $request->user();

    $user->fcm_token = $request['fcm_token'];

    $user->save();

    $response = [
      'message' => 'FCM Token updated.',
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
