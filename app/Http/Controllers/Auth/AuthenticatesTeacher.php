<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginToken;
use App\Models\TeacherUser;

class AuthenticatesTeacher extends Controller
{
    public function invite(TeacherUser $user)
    {
        $this->createToken($user)
            ->send();
    }

    public function createToken(TeacherUser $user)
    {
        return LoginToken::generateFor($user);
    }
}
