<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\AuthenticateUser;
use App\LoginToken;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthenticateUser $auth)
    {
        $this->auth = $auth;
    }

    public function login()
    {
        return view('login');
    }

    public function postLogin()
    {
        $this->auth->invite();

        return 'Sweet - go check that email, yo.';
    }

    public function authenticate(LoginToken $token)
    {
        $this->auth->login($token);

        return redirect('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
