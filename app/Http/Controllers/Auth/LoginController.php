<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $req)
    {
        $http = new \GuzzleHttp\Client;

        $this->validate($req, [
            'username' => 'required',
            'password' => 'required|min:3',
        ]);

        $response = $http->post('http://kazhal.test/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '1',
                'client_secret' => 'NWIJgjVP9htrsCWJoBcNCMQtwQwFd0TnorNxYLk6',
                'username' => $req->get('username'),
                'password' => $req->get('password'),
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
    
    public function logout(Request $req)
    {
        $req->user()->token()->revoke();
        
        return response()->json([
            'status'  => "ok",
            'message' => 'Loged Out'
        ]);
    }
}
