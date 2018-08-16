<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{

	/**
	 * @SWG\Get(
	 *   path="/user/{userId}/customer",
	 *   tags={"customer"},
	 *   summary="Get user's customers informations",
	 *   operationId="userCustomerInfo",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
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

    /**
	 * @SWG\Put(
	 *   path="/user/{userId}/customer/{customerId}",
	 *   tags={"customer"},
	 *   summary="Update customer informations",
	 *   operationId="userCustomerUpdate",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="customerId",
	 *     in="path",
	 *     description="Customer Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function update()
    {
    	//
    }

    /**
	 * @SWG\Delete(
	 *   path="/user/{userId}/customer/{customerId}",
	 *   tags={"customer"},
	 *   summary="Delete customer informations",
	 *   operationId="userCustomerDelete",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="customerId",
	 *     in="path",
	 *     description="Customer Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function delete()
    {
    	//
    }
}
