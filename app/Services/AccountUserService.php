<?php

namespace App\Services;

use App\User;
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


    
}