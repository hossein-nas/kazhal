<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\Controller;

class UserThumbnailController extends Controller
{
    public function update(User $user)
    {
        if (request()->has('thumbnail_id')) {
            $user->updateThumbnail(request()->get('thumbnail_id'));

            return response([], 201);
        }

        return abort(403, 'Wrong paramaters');
    }
}
