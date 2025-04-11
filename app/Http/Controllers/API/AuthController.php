<?php

namespace App\Http\Controllers\API;
use App\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    use ApiResponse;
    public function signup(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors()->all(), 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return $this->sendResponse($user, 'User successfully registered', 201);

    }
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Authentication Failed', $validator->errors()->all(), 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            $token = $user->createToken('Api Token')->plainTextToken;

            return $this->sendResponse([
                'token' => $token,
                'token_type' => 'bearer'
            ], 'User login successful');
        }

        return $this->sendError('Unauthorized | Email & Password Does Not Match', [], 401);
    }
    public function logout(Request $request){

        $request->user()->tokens()->delete();

        return $this->sendResponse(null, 'User successfully registered', 200);


    }

}
