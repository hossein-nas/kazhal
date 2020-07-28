<?php

namespace App\Http\Controllers\Auth;

use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $req
     */
    public function login(Request $req)
    {
        $http = new \GuzzleHttp\Client;

        $this->validate($req, [
            'username' => 'required',
            'password' => 'required|min:3',
        ]);

        $response = $http->post(config('app.url') . 'oauth/token', [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => '1',
                'client_secret' => 'vHqGoDqPDFwwqiPeqT8qXTBFbBPO8AZX2HiJvfOd',
                'username'      => $req->get('username'),
                'password'      => $req->get('password'),
                'scope'         => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * @param Request $req
     */
    public function logout(Request $req)
    {
        $req->user()->token()->revoke();

        return response()->json([
            'status'  => "ok",
            'message' => 'Loged Out',
        ]);
    }
}
