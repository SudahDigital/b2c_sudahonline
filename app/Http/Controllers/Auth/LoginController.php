<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    
    protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = '/home';
    protected function redirectTo()
    {
        /*
        if ((in_array("SUPERADMIN", json_decode(auth()->user()->roles))) || (in_array("ADMIN", json_decode(auth()->user()->roles)))) {
            return '/home';
        }else if (in_array("SALES", json_decode(auth()->user()->roles))) {
            return '/home_customer';
        }
        return '/';
        */
        /*
        if (in_array(auth()->user()->roles, ['SUPERADMIN']))
        {
            return '/home';
        }
        else if (in_array(auth()->user()->roles, ['SALES'])) 
        {
            return '/home_customer';
        }
        return '/';
        */
        
        if ((auth()->user()->roles == 'SUPERADMIN') || (auth()->user()->roles == 'ADMIN') || (auth()->user()->roles == 'SUPERVISOR')) {
            return '/home';
        }else if (auth()->user()->roles == 'SALES') {
            return '/sales_home';
        }
        return '/';
        
        /*$roles = \Auth::user()->roles; 
        switch ($roles) {
            case 'ADMIN':
                return '/home';
            break;
            case 'SUPERADMIN':
                return '/home';
            break;
            case 'SUPERADMIN':
                return '/sales_home';
            break;  

            default:
                return '/login'; 
            break;
        }*/
    }

    

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
        return ['email'=>$request->{
            $this->username()
        }, 'password'=>$request->password, 'status'=>'ACTIVE'];
    }

    public function showLoginForm()
    {
        $categories = \App\Category::get();    
        return view('auth.login', ['categories'=> $categories]);
    }
}
