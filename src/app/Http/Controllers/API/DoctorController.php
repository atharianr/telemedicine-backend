<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Client\Request;

class DoctorController extends Controller
{
  public function getAllDoctors()
  {
    $data = Doctor::all();

    if (count($data) > 0) {
      return response()->json([
        'code' => 200,
        'message' => 'All doctors fetched.',
        'data' => $data
      ]);
    } else {
      return response()->json([
        'code' => 404,
        'message' => 'No doctor found.'
      ]);
    }
  }

  public function searchDoctor(Request $request)
  {

    $pagination  = 5;
    $data = Doctor::when($request->keyword, function ($query) use ($request) {
      $query
        ->where('name', 'like', "%{$request->keyword}%");
    })->orderBy('created_at', 'desc')->paginate($pagination);

    $data = json_encode($data);
    $data = json_Decode($data);

    if ($data->total > 0) {
      return response()->json([
        'code' => 200,
        'message' => 'Query doctors fetched.',
        'data' => $data->data
      ]);
    } else {
      return response()->json([
        'code' => 404,
        'message' => 'No query doctor found.'
      ]);
    }
  }
}
