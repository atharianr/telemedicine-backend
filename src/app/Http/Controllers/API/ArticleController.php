<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article as ModelsArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getAllArticles()
    {
        $data = ModelsArticle::all();

        if (count($data) > 0) {
            return response()->json([
                'code' => 200,
                'message' => 'All articles fetched.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No article found.'
            ]);
        }
    }

    public function searchArticle(Request $request)
    {

        $pagination  = 5;
        $data = ModelsArticle::when($request->keyword, function ($query) use ($request) {
            $query
                ->where('name', 'like', "%{$request->keyword}%");
        })->orderBy('created_at', 'desc')->paginate($pagination);

        $data = json_encode($data);
        $data = json_Decode($data);

        if ($data->total > 0) {
            return response()->json([
                'code' => 200,
                'message' => 'Query articles fetched.',
                'data' => $data->data
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No query article found.'
            ]);
        }
    }
}
