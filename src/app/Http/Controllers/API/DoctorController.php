<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;

class DoctorController extends Controller
{
  public function getAllDoctors()
  {
    $data = Doctor::all();

    if ($data) {
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
}
