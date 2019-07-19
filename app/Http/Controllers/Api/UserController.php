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

    public function login()
    {

    }

    public function details()
    {

    }
}
