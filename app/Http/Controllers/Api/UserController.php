<?php

namespace App\Http\Controllers\Api;

use App\Services\AccountUserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $_user;

    public function __construct(AccountUserService $userService)
    {
        $this->_user = $userService;
    }

    public function store(Request $request)
    {
        return $this->_user->register($request);
    }

    public function login(Request $request)
    {
        return $this->_user->login($request);
    }

    public function logout(Request $request)
    {
        return $this->_user->logout($request);
    }

    public function show(Request $request)
    {
        return $this->_user->user($request);
    }
}
