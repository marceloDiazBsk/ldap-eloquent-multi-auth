<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showAdminLoginForm(){
        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request){
        $credentials = [
            'uid' =>  $request->username,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
            return redirect()->intended('/home/admin');
        }
        return back()->withInput($request->only('username', 'remember'));
    }

    public function showProviderLoginForm(){
        return view('auth.login', ['url' => 'provider']);
    }

    public function providerLogin(Request $request){
        $credentials = [
            'email' =>  $request->username,
            'password' => $request->password
        ];
        if (Auth::guard('provider')->attempt($credentials, $request->get('remember'))) {
            return redirect()->intended('/home/provider');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

}
