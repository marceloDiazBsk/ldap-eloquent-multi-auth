<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use LdapRecord\Models\ActiveDirectory\User as ActiveDirectoryUser;

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

    //ldap.forumsys.com
    /*public function adminLogin(Request $request){
        $credentials = [
            'uid' =>  $request->username,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
            return redirect()->intended('/home/admin');
        }
        return back()->withInput($request->only('username', 'remember'));
    }*/

    //active directory
    public function adminLogin(Request $request){
        $credentials = [
            'samaccountname' =>  $request->username,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
            if($this->validateGroup()){
                return redirect()->intended('/home/admin');
            }else{
                Auth::guard('admin')->user()->delete();
                Auth::logout();
                return back()->withInput($request->only('username', 'remember'));
            }
            
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

    private function validateGroup(){
        $user = Auth::guard('admin')->user();
        $activeDirectoryUser = ActiveDirectoryUser::findByGuid($user->guid);
        $memberOf = $activeDirectoryUser->memberof;
        $memberList = array();
        foreach($memberOf as $member){
            $memberList = array_merge($memberList,explode(',',$member));
        }
        return in_array('CN=PL_Users',$memberList);
    }

}
