<?php

namespace App\Services\Security;


use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * get currently logged in user
     *
     **/
    public static function getLoggedInUser()
    {
        return Auth::user();
    }

}
