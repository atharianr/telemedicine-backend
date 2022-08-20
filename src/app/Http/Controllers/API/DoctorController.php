<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

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

  public function searchFilterDoctor(Request $request)
  {
    $pagination  = 5;
    $data = Doctor::when($request->keyword, function ($query) use ($request) {
      $query
        ->where('name', 'like', "%{$request->keyword}%");
    })
    ->when($request->filter, function ($query) use ($request) {
      $filterWord = explode('-',$request->filter);
      foreach ($filterWord as $word) {
        $query
          ->orWhere('specialist', 'like', '%'.$word.'%');
      }
      
    })
    ->orderBy('created_at', 'desc')->paginate($pagination);
    
    // $data = Doctor::orderBy('created_at', 'desc')->paginate($pagination);

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
