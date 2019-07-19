<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountUserService
{

    private $_User;

    public function __construct(User $user)
    {
        $this->_User = $user;
    }

    public function register($request)
    {
        $inputCreate = $request->json()->all();
        $validator = Validator::make($inputCreate, $this->_User->rulesCreateUser());

        if ($validator->fails()) {
            return response()->json(['errors' => parseErrToJson($validator)], 422); // 422 UnProcessable Entity
        }

        $createdSuccess = $this->_User::create([
            'name' =>$inputCreate['name'],
            'email' => $inputCreate['email'],
            'password' => bcrypt($inputCreate['password']),
            'hide' => 0
        ]);

        if ($createdSuccess) {
            return response()->json(['message' => 'Successfully created user!'], 201);
        }

        return response()->json(['message' => 'Unauthorized: Processing create break !'], 409);
    }

    public function login($request)
    {
        $requestLogin = $request->json()->all();
        $validator = Validator::make($requestLogin, $this->_User->rulesLoginUser());

        if ($validator->fails()) {
            return response()->json(['errors' => parseErrToJson($validator)], 422); // 422 UnProcessable Entity
        }

        if ( ! Auth::attempt(['email' => $requestLogin['email'], 'password' => $requestLogin['password']]))
            return response()->json(['errors' => 'Not Acceptable: login fails'], 406); // login fails

        $user = $request->user();// return info user authentication

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($requestLogin['remember_me'])
            $token->expires_at = Carbon::now()->addWeek(1);
        $token->save();


        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ], 200);

    }

    public function logout($request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function user($request)
    {
        return response()->json($request->user());
    }
}