<?php

namespace DatLichVietAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DatLichVietAPI\User;
use DatLichVietAPI\Models\UserVerification;
use DatLichVietAPI\Models\UserProfile;
use DatLichVietAPI\Models\UserFacebook;
use DatLichVietAPI\Models\UserDevice;
use DatLichVietAPI\Models\Customer;
use Validator;
use Illuminate\Support\Facades\Storage;
use DatLichVietAPI\Notifications\SignUp;
use DatLichVietAPI\Notifications\PhoneVerification;

class UserController extends Controller
{
	private function standardPhone($phone)
	{
		// Convert standard phone number
		if (substr($phone, 0, 1) == "0") {
			return "84" . substr($phone, 1);
		} elseif (substr($phone, 0, 3) == "+") {
			return substr($phone, 1);
		}

		return $phone;
	}
	/**
	 * @SWG\Post(
	 *   path="/user/register",
	 *   tags={"user"},
	 *   summary="Register new user",
	 *   operationId="userRegister",
	 *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *	   description="JSON body request.",
     *     required=true,
     *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="email",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="phone",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="password",
	 *         type="string"
	 *       )
	 *	   )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function register(Request $request)
	{
		$request->validate([
			'email' => 'required|string|email|unique:users',
			'phone' => 'required|string|unique:users|min:10|max:13',
			'password' => 'required|string'
		]);

		// Convert standard phone number
		$std_phone = $this->standardPhone($request->phone);

		$user = new User([
			'type' => 'normal',
			'email' => $request->email,
			'phone' => $std_phone,
			'password' => bcrypt($request->password),
			'status' => 0
		]);

		$user->save();

		// Create user profile
		$user_profile = new UserProfile([
			'user_id' => $user->id,
			'full_name' => Null,
			'gender' => Null,
			'dob' => Null,
			'avatar' => Null,
			'address' => Null,
			'ward' => Null,
			'city' => Null,
			'province' => Null
		]);

		$user_profile->save();

		// // Create customer profile
		// $customer = new Customer([
		// 	'full_name' => Null,
		// 	'gender' => Null,
		// 	'dob' => Null,
		// 	'blood' => Null,
		// 	'address' => Null,
		// 	'ward' => Null,
		// 	'city' => Null,
		// 	'province' => Null
		// ]);

		// $customer->save();

		// $user->customers()->save($customer, ['relationship_id' => 1]);

		// Notify register email
		$user->notify(new Signup($user));

		// Create verify code
		$std_code = new UserVerification([
			'user_id' => $user->id,
			'code' => rand(100000, 999999)
		]);

		$std_code->save();

		$sms_request = "http://210.211.97.22:8083/api/sentEx?username=aivietnam&password=ai21nAm&source_addr=SoLienLacDT&dest_addr=" . $std_phone . "&message=Ma xac thuc cua quy khach la: " . $std_code->code . ", co hieu luc trong 5 phut ke tu luc gui.&type=8&request_id=" . $user->id . "_" . $std_code->id . "&telco_code=NA";
		file_get_contents($sms_request);

		// Login user
		Auth::login($user);

		$token =  $user->createToken('DatLichVietAPI');
		$token->token->expires_at = Carbon::now()->addDays(365);
        $token->token->save();

		return response()->json([
			'status' => 'success',
			'data' => [
				'user_id' => $user->id,
				'access_token' => $token->accessToken,
				'token_type' => 'Bearer'
			]
		], 200);
	}

	/**
	 * @SWG\Post(
	 *   path="/user/login",
	 *   tags={"user"},
	 *   summary="Login user",
	 *   operationId="userLogin",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="username",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="password",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="remember_me",
	 *         type="boolean"
	 *       )
	 *	   )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function login(Request $request)
	{
		$request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

		if (Auth::attempt(['email' => $request->username, 'password' => $request->password])
			|| Auth::attempt(['phone' => $request->username, 'password' => $request->password])){

			$user = Auth::user();
			$token =  $user->createToken('DatLichVietAPI');

			if ($request->remember_me)
            	$token->token->expires_at = Carbon::now()->addDays(365);

            $token->token->save();

			return response()->json([
				'status' => 'success',
				'data' => [
					'user_id' => $user->id,
					'access_token' => $token->accessToken,
					'token_type' => 'Bearer'
				]
			], 200);
		}
		else{
			return response()->json([
				'status'=>'error',
				'data' => [
					'message' => 'Unauthenticated'
				]
			], 401);
		}
	}

	/**
	 * @SWG\Post(
	 *   path="/user/loginFacebook",
	 *   tags={"user"},
	 *   summary="Login facebook user",
	 *   operationId="userLoginFacebook",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="accessToken",
	 *         type="string"
	 *       )
	 *	   )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function loginFacebook(Request $request)
	{
		$request->validate([
            'accessToken' => 'required|string'
        ]);

        // Get facebook information from facebook API
        $facebook_data = json_decode(file_get_contents('https://graph.facebook.com/v3.1/me?fields=birthday%2Cemail%2Cname%2Cfirst_name%2Clast_name%2Cgender&access_token=' . $request->accessToken));

        if ($facebook_data) {
        	$user_check = User::find(['email' => $facebook_data->email])->first();

        	if ($user_check != null) {
        		return response()->json([
        			'status' => 'error',
        			'errors' => [
        				'email' => 'Email was exists.'
        			]
        		]);
        	}
        } else {
        	return response()->json([
    			'status' => 'error',
    			'errors' => [
    				'facebook' => "Can't get facebook user information."
    			]
    		]);
        }

		$user = new User([
			'type' => 'facebook',
			'email' => $facebook_data->email,
			'phone' => '',
			'password' => '',
			'status' => 1
		]);

		$user->save();

		$user_facebook = $user->facebook()->create([
			'access_token' => $request->accessToken
		]);

		$user_profile = $user->profile()->create([
			'full_name' => $facebook_data->first_name . " " . $facebook_data->last_name,
			'gender' => $facebook_data->gender,
			'dob' => $facebook_data->birthday
		]);

		// Login user
		Auth::login($user);

		$token =  $user->createToken('DatLichVietAPI');
		$token->token->expires_at = Carbon::now()->addDays(365);
        $token->token->save();

		return response()->json([
			'status' => 'success',
			'data' => [
				'user_id' => $user->id,
				'access_token' => $token->accessToken,
				'token_type' => 'Bearer'
			]
		], 200);
	}

	/**
	 * @SWG\Post(
	 *   path="/user/forgot",
	 *   tags={"user"},
	 *   summary="Forgot password",
	 *   operationId="userForgot",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="phone",
	 *         type="string"
	 *       )
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function forgot(Request $request)
	{
		$request->validate([
            'phone' => 'required|string'
        ]);

		// Convert standard phone number
		$std_phone = $this->standardPhone($request->phone);

        $user = User::find(['phone' => $std_phone]);

        if (! $user) {
        	// Return status
	        return response()->json([
	        	'status' => 'error',
	        	'message' => 'Phone number was not exists.'
	        ], 200);
        }

        // Create verify code
		$std_code = new UserVerification([
			'user_id' => $user->id,
			'code' => rand(100000, 999999)
		]);

		$std_code->save();

		$sms_request = "http://210.211.97.22:8083/api/sentEx?username=aivietnam&password=ai21nAm&source_addr=SoLienLacDT&dest_addr=" . $std_phone . "&message=Ma xac thuc cua quy khach la: " . $std_code->code . ", co hieu luc trong 5 phut ke tu luc gui.&type=8&request_id=" . $user->id . "_" . $std_code->id . "&telco_code=NA";
		file_get_contents($sms_request);

        // Return status
        return response()->json([
        	'status' => 'success',
        	'data' => []
        ], 200);
	}

	/**
	 * @SWG\Post(
	 *   path="/user/verify",
	 *   tags={"user"},
	 *   summary="Verify user action",
	 *   operationId="userVerify",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="phone",
	 *         type="string"
	 *       )
	 *     ),
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="code",
	 *         type="string"
	 *       )
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function verify(Request $request)
	{
		$request->validate([
            'phone' => 'required|string',
            'code' => 'required|string'
        ]);

        // Convert standard phone number
		$std_phone = $this->standardPhone($request->phone);

        $user = User::where('phone', $std_phone)->first();

        if (! $user) {
        	// Return status
	        return response()->json([
	        	'status' => 'error',
	        	'message' => 'Phone number was not exists.'
	        ], 200);
        }

        if (time() - $user->verify->last()->created_at->getTimestamp() - 300 > 0) {
        	// Return status
	        return response()->json([
	        	'status' => 'error',
	        	'message' => 'Verify code was expired.'
	        ], 200);
        }

        if ($request->code !== $user->verify->last()->code) {
        	// Return status
	        return response()->json([
	        	'status' => 'error',
	        	'message' => 'Verify code was not right.'
	        ], 200);
        }

        // Return status
        return response()->json([
        	'status' => 'success',
        	'data' => []
        ], 200);
	}

	/**
	 * @SWG\Get(
	 *   path="/user",
	 *   tags={"user"},
	 *   summary="Get user informations",
	 *   operationId="userInfo",
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function info(Request $request)
	{
    	return response()->json([
    		'status' => 'success',
    		'data' => $request->user()
    	]);
	}

	/**
	 * @SWG\Put(
	 *   path="/user",
	 *   tags={"user"},
	 *   summary="Update user information",
	 *   operationId="userUpdate",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="fullName",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="gender",
	 *         type="string",
	 *	       enum={"male", "female", "lbgt"},
	 *	       default="male"
	 *       ),
	 *       @SWG\Property(
	 *         property="birthDay",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="streetAddress",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="ward",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="city",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="province",
	 *         type="string"
	 *       )
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function update(Request $request)
	{
		$request->validate([
			'fullName' => 'string|required',
			'gender' => 'string|required',
			'birthDay' => 'date|required',
			'streetAddress' => 'string|required',
			'ward' => 'string|required',
			'city' => 'string|required',
			'province' => 'string|required'
		]);

		$request->user()->profile->full_name = $request->fullName;
		$request->user()->profile->gender = $request->gender;
		$request->user()->profile->dob = $request->birthDay;
		$request->user()->profile->address = $request->streetAddress;
		$request->user()->profile->ward = $request->ward;
		$request->user()->profile->city = $request->city;
		$request->user()->profile->province = $request->provinc;

		$request->user()->profile->save();

		return response()->json([
        	'status' => 'success',
        	'data' => []
        ], 200);
	}

	/**
	 * @SWG\Put(
	 *   path="/user/avatar",
	 *   tags={"user"},
	 *   summary="Update user avatar (image data in base64_encode string)",
	 *   operationId="userAvatar",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="mimeType",
	 *         type="string"
	 *       ),
	 *       @SWG\Property(
	 *         property="image",
	 *         type="string"
	 *       )
	 *	   )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error"),
	 *   deprecated=true
	 * )
	 *
	 */
	public function avatar(Request $request)
	{
		$request->validate([
            'image' => 'required|string'
        ]);

        $info = getimagesizefromstring(explode(',', base64_decode($request->image)[0], 2));

        return response()->json([
        	'status' => 'success',
        	'data' => $info
        ], 200);

        Storage::disk('public')->put($request->user()->id . '_avatar.' . 'png', base64_decode($request->image));

        return response()->json([
        	'status' => 'success',
        	'data' => [
        		'image' => "https://static.datlichviet.com/images/avatar/" . $request->user()->id . '_avatar.' . 'png'
        	]
        ], 200);
	}

	/**
	 * @SWG\Put(
	 *   path="/user/password",
	 *   tags={"user"},
	 *   summary="Set new password",
	 *   operationId="userPassword",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="password",
	 *         type="string"
	 *       )
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error")
	 * )
	 *
	 */
	public function password(Request $request)
	{
		$request->validate([
            'password' => 'required|string'
        ]);

		$user = $request->user();
		$user->password = bcrypt($request->password);
		$user->save();

		return response()->json([
			'status' => 'success',
			'data' => []
		]);
	}

	/**
	 * @SWG\Put(
	 *   path="/user/device",
	 *   tags={"user"},
	 *   summary="Set device token for push notification",
	 *   operationId="userDevice",
	 *   @SWG\Parameter(
	 *	   name="body",
	 *	   in="body",
	 *	   description="JSON body request.",
	 *	   required=true,
	 *	   @SWG\Schema(
	 *	     type="object",
	 *       @SWG\Property(
	 *         property="type",
	 *         type="string",
	 *         enum={"ios", "android"},
	 *         default="android"
	 *       ),
	 *       @SWG\Property(
	 *         property="token",
	 *         type="string"
	 *       )
	 *     )
	 *   ),
	 *   @SWG\Response(response=200, description="successful operation"),
	 *   @SWG\Response(response=406, description="not acceptable"),
	 *   @SWG\Response(response=500, description="internal server error"),
	 * )
	 *
	 */
	public function device(Request $request)
	{
		$request->validate([
            'type' => 'required|string',
            'token' => 'required|string'
        ]);

		$user = $request->user();

		if ($user->device) {
			$user->device->token = $request->token;
			$user->device->save();
		} else {
			$user->device()->create(['type' => $request->type, 'token' => $request->token, 'status' => 1]);
		}

		return response()->json([
			'status' => 'success',
			'data' => []
		]);
	}

	/**
	 * @SWG\Get(
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
			'status' => 'success',
			'data' => []
		]);
	}

}
