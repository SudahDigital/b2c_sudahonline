<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;

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
    /*
    protected $redirectTo = RouteServiceProvider::HOME;
    
    protected function redirectTo()
    {
        if (auth()->user()->roles == 'ADMIN') {
            return '/home';
        }else if (auth()->user()->roles == 'CUSTOMER') {
            return '/home_customer';
        }
        return '/home';
        
    }*/

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

    protected function credentials(Request $request)
    {
        //return $request->only($this->username(), 'password');
        $password = Crypt::encrypt($request->password);
        return ['email'=>$request->{
            $this->username()
        }, 'password'=>$request->password, 'status'=>'ACTIVE'];
    }

    public function showLoginForm()
    {
        $categories = \App\Category::get();    
        // return view('auth.login', ['categories'=> $categories]);
        return redirect()->route('home');
    }
}
