<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
	public function getAllDoctors()
	{
		$data = Doctor::select('id', 'name', 'specialist', 'photo')->get()->toArray();

		if (count($data) > 0) {
			return response()->json([
				'code' => 200,
				'message' => 'All doctors fetched.',
				'data' => $data
			], 200);
		} else {
			return response()->json([
				'code' => 404,
				'message' => 'No doctor found.'
			], 404);
		}
	}

	public function searchFilterDoctor(Request $request)
	{
		$pagination  = 100;
		$data = Doctor::select('id', 'name', 'specialist', 'photo')->when($request->keyword, function ($query) use ($request) {
			$query
				->where('name', 'like', "%{$request->keyword}%");
		})
			->when($request->filter, function ($query) use ($request) {
				$query->where(function ($query2) use ($request) {
					$filterWord = explode('-', $request->filter);
					foreach ($filterWord as $word) {
						$query2->orWhere("specialist", "like", '%' . $word . '%');
					}
				});
			})
			->orderBy('name', 'asc')->paginate($pagination);

		// $data = Doctor::orderBy('created_at', 'desc')->paginate($pagination);

		$data = json_encode($data);
		$data = json_Decode($data);

		if ($data->total > 0) {
			return response()->json([
				'code' => 200,
				'message' => 'Query doctors fetched.',
				'data' => $data->data
			], 200);
		} else {
			return response()->json([
				'code' => 404,
				'message' => 'No query doctor found.'
			], 404);
		}
	}

	public function getDoctorDetail($id)
	{
		$data = Doctor::where('id', '=', $id)->get();

		if (count($data) > 0) {
			return response()->json([
				'code' => 200,
				'message' => 'Doctor detail fetched.',
				'data' => $data[0]
			], 200);
		} else {
			return response()->json([
				'code' => 404,
				'message' => 'Doctor not found.'
			], 404);
		}
	}
}
