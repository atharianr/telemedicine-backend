<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article as ModelsArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getAllArticles()
    {
        // $data = ModelsArticle::all();
        $data = ModelsArticle::select('id', 'name')->get()->toArray();

        if (count($data) > 0) {
            return response()->json([
                'code' => 200,
                'message' => 'All articles fetched.',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No article found.'
            ], 404);
        }
    }

    public function searchArticle(Request $request)
    {

        $pagination  = 100;
        $data = ModelsArticle::select('id', 'name')->when($request->keyword, function ($query) use ($request) {
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
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No query article found.'
            ], 404);
        }
    }

    public function getArticleDetail($id)
    {
        $data = ModelsArticle::where('id', '=', $id)->get();

        if (count($data) > 0) {
            return response()->json([
                'code' => 200,
                'message' => 'Article detail fetched.',
                'data' => $data[0]
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Article not found.'
            ], 404);
        }
    }
}
