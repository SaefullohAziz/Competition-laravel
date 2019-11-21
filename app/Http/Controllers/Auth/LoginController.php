<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Judge;
use App\Administrator;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:juri')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $administrator = Administrator::where('email', $request->username)->orWhere('username', $request->username)->first();
        $judge = Judge::where('email', $request->username)->orWhere('username', $request->username)->first();
        $user = User::where('email', $request->username)->orWhere('username', $request->username)->orWhereHas('school', function ($query) use ($request) {
            $query->where('email', $request->username);
        })->first();
        if ($administrator) {
            if (Hash::check($request->password, $administrator->password)) {
                return Auth::guard('admin')->login(
                    $administrator, $request->filled('remember')
                );
            }
        } elseif ($judge) {
            if (Hash::check($request->password, $judge->password)) {
                return Auth::guard('juri')->login(
                    $judge, $request->filled('remember')
                );
            }
        }  elseif ($user) {
            if (Hash::check($request->password, $user->password)) {
                return Auth::guard()->login(
                    $user, $request->filled('remember')
                );
            }
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $request->session()->flash('logged-in', __('Logged In!'));
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin');
        }
        if (Auth::guard('juri')->check()) {
            return Auth::guard('juri');
        }
        return Auth::guard();
    }
}
