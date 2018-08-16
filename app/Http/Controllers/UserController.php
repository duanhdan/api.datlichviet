<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DatLichVietAPI\User;
use Validator;

class UserController extends Controller
{
	/**
	 * @SWG\POST(
	 *   path="/user/register",
	 *   tags={"user"},
	 *   summary="Register new user",
	 *   operationId="userRegister",
	 *   @SWG\Parameter(
	 *     name="email",
	 *     in="body",
	 *     description="User email.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
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
	 *   @SWG\Parameter(
	 *     name="password",
	 *     in="body",
	 *     description="User password.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="confirmPassword",
	 *     in="body",
	 *     description="User confirm password.",
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
	public function register()
	{
		$request->validate([
			'user_type' => 'required|string'
		]);
		$user_type = $request->input('user_type');

		if ($user_type == 'normal') {
			$request->validate([
				'email' => 'required|string|email|unique:users',
				'phone' => 'required|string',
				'password' => 'required|string|confirmed'
			]);
		}

		else if ($user_type == 'facebook') {
			$request->validate([
				'user_id' => 'required|string|email|unique:users',
				'phone' => 'required|string',
				'password' => 'required|string|confirmed'
			]);
		}

		$user = new User([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password)
		]);

		$user->save();

		return response()->json([
			'message' => 'Successfully created user!'
		], 201);
	}

	/**
	 * @SWG\POST(
	 *   path="/user/login",
	 *   tags={"user"},
	 *   summary="Login user",
	 *   operationId="userLogin",
	 *   @SWG\Parameter(
	 *     name="email",
	 *     in="body",
	 *     description="User email.",
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
	public function login()
	{
		//
	}

	/**
	 * @SWG\POST(
	 *   path="/user/loginFacebook",
	 *   tags={"user"},
	 *   summary="Login facebook user",
	 *   operationId="userLoginFacebook",
	 *   @SWG\Parameter(
	 *     name="facebookId",
	 *     in="body",
	 *     description="User facebook Id.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="accessToken",
	 *     in="body",
	 *     description="User facebook access token.",
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
	public function loginFacebook()
	{
		//
	}

	/**
	 * @SWG\POST(
	 *   path="/user/{userId}/forgot",
	 *   tags={"user"},
	 *   summary="Forgot password",
	 *   operationId="userForgot",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
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
	public function forgot()
	{
		//
	}

	/**
	 * @SWG\POST(
	 *   path="/user/{userId}/verify",
	 *   tags={"user"},
	 *   summary="Verify user action",
	 *   operationId="userVerify",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="code",
	 *     in="body",
	 *     description="Verify code.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="int"
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function verify()
	{
		//
	}

	/**
	 * @SWG\GET(
	 *   path="/user/{userId}",
	 *   tags={"user"},
	 *   summary="Get user informations",
	 *   operationId="userInfo",
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
	 * @SWG\PUT(
	 *   path="/user/{userId}",
	 *   tags={"user"},
	 *   summary="Update user information",
	 *   operationId="userUpdate",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="name",
	 *     in="body",
	 *     description="User display name.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="firstName",
	 *     in="body",
	 *     description="User first name.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="lastName",
	 *     in="body",
	 *     description="User last name.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="gender",
	 *     in="body",
	 *     description="User gender.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string",
	 *       enum={"male", "female", "lbgt"},
     *       default="male"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="dob",
	 *     in="body",
	 *     description="User birthday.",
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
	public function update()
	{
		//
	}

	/**
	 * @SWG\PUT(
	 *   path="/user/{userId}/avatar",
	 *   tags={"user"},
	 *   summary="Update user avatar",
	 *   operationId="userAvatar",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="avatar",
	 *     in="body",
	 *     description="User avatar.",
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
	public function avatar()
	{
		//
	}

	/**
	 * @SWG\PUT(
	 *   path="/user/{userId}/password",
	 *   tags={"user"},
	 *   summary="Set new password",
	 *   operationId="userPassword",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="password",
	 *     in="body",
	 *     description="User new password.",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @SWG\Parameter(
	 *     name="confirmPassword",
	 *     in="body",
	 *     description="User new confirm password.",
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
	public function password()
	{
		//
	}

	/**
	 * @SWG\PUT(
	 *   path="/user/{userId}/device",
	 *   tags={"user"},
	 *   summary="Set device token for push notification",
	 *   operationId="userDevice",
	 *   @SWG\Parameter(
	 *     name="userId",
	 *     in="path",
	 *     description="User Id.",
	 *     required=true,
	 *     type="integer"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="type",
	 *     in="body",
	 *     description="Device type (iOS/android).",
	 *     required=true,
	 *     @SWG\Schema(
	 *       type="string",
	 *       enum={"ios", "android"},
	 *       default="android"
	 *     )
	 *   ),
	 *     @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status values that need to be considered for filter",
     *         required=true,
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *             default="available"
     *         ),
     *         collectionFormat="multi"
     *     ),
	 *   @SWG\Parameter(
	 *     name="token",
	 *     in="body",
	 *     description="Device token.",
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
	public function device()
	{
		//
	}

	/**
	 * @SWG\GET(
	 *   path="/user/logout",
	 *   tags={"user"},
	 *   summary="Logout current user",
	 *   operationId="userLogout",
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function logout(Request $request)
	{
		$request->user()->token()->revoke();

		return response()->json([
			'message' => 'Successfully logged out'
		]);
	}

}
