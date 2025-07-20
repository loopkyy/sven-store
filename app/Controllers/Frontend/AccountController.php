<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class AccountController extends BaseController
{
    public function index()
    {
        $user = session()->get();
        return view('frontend/account/index', ['user' => $user]);
    }
}
