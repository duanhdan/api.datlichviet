<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Http\Request;
use DatLichVietAPI\Models\Category;
use DatLichVietAPI\Models\News;

class NewsController extends Controller
{
	/**
	 * @SWG\Get(
	 *   path="/news",
	 *   tags={"news"},
	 *   summary="Get news informations",
	 *   operationId="newsList",
	 *   @SWG\Parameter(
	 *     name="category",
	 *     in="query",
	 *     description="Category slug (Ex: tin-tuc)",
	 *     required=false,
	 *     type="string"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="search",
	 *     in="query",
	 *     description="Search string",
	 *     required=false,
	 *     type="string"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="page",
	 *     in="query",
	 *     description="Page number",
	 *     required=false,
	 *     type="integer"
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function index(Request $request)
    {
    	$query = News::with('category');

    	if ($request->search) {
    		$query = $query->where('title', 'like', '%' . $request->search . '%');
    						// ->where('content', 'like', '%' . $request->search . '%');
    	}

    	if ($request->category) {
    		$category = Category::where('slug', $request->category)->first();

    		if ($category)
    			$query = $query->where('category_id', $category->id);
    		else
    			return response()->json([
				'status' => 'success',
				'data' => []
			]);
    	}

		if ($request->page) {
    		$query = $query->offset(($request->page - 1) * 6)->limit(6);
    	} else {
    		$query = $query->offset(0)->limit(7);
    	}

    	$posts = $query->orderBy('created_at', 'desc')->get();

    	return response()->json([
			'status' => 'success',
			'data' => $posts
		]);
    }

    /**
	 * @SWG\Get(
	 *   path="/news/{newsId}",
	 *   tags={"news"},
	 *   summary="Get news informations",
	 *   operationId="newsInfo",
	 *   @SWG\Parameter(
	 *     name="newsId",
	 *     in="path",
	 *     description="news Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function info($id)
    {
    	$post = News::with('category')->findOrFail($id);

    	return response()->json([
    		'status' => 'success',
    		'data' => $post
    	]);
    }
}
