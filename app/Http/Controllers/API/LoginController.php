<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

        public function logout(Request $request)
        {
            if (Auth::user()) {
                $request->user()->token()->revoke();

                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Logged out failed',
                ], 401);
            }
        }
        public function show_all_users(): JsonResponse
    {
        // Retrieve all users
        $users = User::all();

        // Check if users exist
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }

        // Return the users as JSON response
        return response()->json($users, 200);
    }

}
