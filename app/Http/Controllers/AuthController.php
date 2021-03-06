<?php

namespace App\Http\Controllers;

use App\Core\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
            $user = User::where('phone', $request->phone)
                ->first();
            if(!$user)
            {
                return response()->json(["message" => "user not found"], 404);
            }
            if(! Hash::check($request->password, $user->password)) {
                return response()->json(["message" => "wrong password"], 401);
            }

            if (!$token = JWTAuth::customClaims(['exp' => Carbon::now()->addMonths(6)->timestamp])->fromUser($user)) {
                return response()->json(["message" => "incorrect credentials"], 401);
            }

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

}
