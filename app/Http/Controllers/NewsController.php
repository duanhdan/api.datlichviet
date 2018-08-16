<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{

	/**
	 * @SWG\GET(
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
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function index()
    {
    	//
    }

    /**
	 * @SWG\GET(
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
    public function info()
    {
    	//
    }
}
