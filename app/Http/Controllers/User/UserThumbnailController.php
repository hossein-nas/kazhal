<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\Controller;

class UserThumbnailController extends Controller
{
    public function update(User $user)
    {
       return request()->all(); 
    }
}
