<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        // return 'email';
        return 'man_no';
    }

    // protected function authenticated(Request $request, $user)
    // {
    //     //check if the column for password change has been effected, then redirect to a password change page
    //     //dd($user->status);
    // }

    protected function authenticated(Request $request, $user)
    {
        // if(!$user->hasAnyRole()){
        //     redirect()->route('live.agent.dashboard', ['id' => $user->id]);
        // }
        // else
         if ($user->hasRole('agent') && $user->getRoleNames()->count()==1) {
            return redirect()->route('live.agent.dashboard', ['id' => $user->id]);
        }
        else if($user->hasRole('agent') && $user->hasRole('outbound') && $user->getRoleNames()->count()==2) {
            return redirect()->route('live.agent.outbound', ['id' => $user->id]);
        }
        else
        if(!$user->hasAnyRole()){
            redirect()->route('live.agent.dashboard', ['id' => $user->id]);
        }


        return redirect()->intended($this->redirectTo);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        //return redirect()->back()->withInput()->withErrors(['man_no' => "Sorry! man number does not exists in PHRIS or is Inactive"]);
    }
}
