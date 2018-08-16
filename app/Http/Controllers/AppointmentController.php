<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
	/**
	 * @SWG\GET(
	 *   path="/appointment/{appointmentId}",
	 *   tags={"appointment"},
	 *   summary="Get appointment informations",
	 *   operationId="appointmentInfo",
	 *   @SWG\Parameter(
	 *     name="appointmentId",
	 *     in="path",
	 *     description="appointment Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="body",
	 *     description="user Id.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="integer"
	 *     )
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
	 * @SWG\GET(
	 *   path="/appointment/user/{userId}",
	 *   tags={"appointment"},
	 *   summary="Get appointment of user informations",
	 *   operationId="appointmentDetail",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="user Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function user()
    {
    	//
    }

    /**
	 * @SWG\GET(
	 *   path="/appointment",
	 *   tags={"appointment"},
	 *   summary="Get appointment clients",
	 *   operationId="appointmentFilter",
	 *   @SWG\Parameter(
	 *     name="specialtyId",
	 *     in="query",
	 *     description="Specialty id",
	 *     required=false,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="address",
	 *     in="query",
	 *     description="Address string",
	 *     required=false,
	 *     type="string"
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function filter()
    {
    	//
    }

    /**
	 * @SWG\POST(
	 *   path="/appointment",
	 *   tags={"appointment"},
	 *   summary="Setup an appointment",
	 *   operationId="appointmentSetup",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="body",
	 *     description="User Id.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="integer"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="phone",
	 *     in="body",
	 *     description="User phone.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function appoint()
    {
    	//
    }

    /**
	 * @SWG\DELETE(
	 *   path="/appointment/{appointmentId}",
	 *   tags={"appointment"},
	 *   summary="Cancel an appointment",
	 *   operationId="appointmentInfo",
	 *   @SWG\Parameter(
	 *     name="appointmentId",
	 *     in="path",
	 *     description="appointment Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="body",
	 *     description="user Id.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="integer"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="reason",
	 *     in="body",
	 *     description="reason cancel.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
    public function cancel()
    {
    	//
    }
}
