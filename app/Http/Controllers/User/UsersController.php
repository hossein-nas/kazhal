<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index()
    {

    }

    public function update(Request $request)
    {
        $res = $this->validateUserSettingUpdate($request->all());
        if( $res['status'] == 'ok'){
            $userId = auth()->user()->id;
            $user = User::findOrFail($userId);
            $user->fill($request->all())->save();
        }
        return $res;
    }

    private function validateUserSettingUpdate($userInfo){
        $validate = Validator::make($userInfo, [
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'bio' => 'nullable|min:10',
        ]);

        if( $validate->fails()){
            return [
                'status'        => 'error',
                'message'       => 'error_in_user_setting_update',
                'text'          => 'اطلاعات وارد شده برای تغییر اطلاعات کاربر نادرست می‌باشد.',
                'data'          => $validate->errors()
            ];
        }

        return [
            'status'        => 'ok',
            'message'       => 'user_info_updated_successfully',
            'text'          => 'اطلاعات کاربر به درستی آپدیت شد.',
            'data'          => null
        ];
    }
}
