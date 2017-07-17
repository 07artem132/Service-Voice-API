<?php

namespace Api\Http\Controllers\Auth;

use Api\Http\Controllers\Auth\VerifyUserController as VerifyUser;
use Illuminate\Support\Facades\Redirect;
use Api\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    protected $guard = 'sentry';

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest.true')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }

    public function login(Request $request)
    {
        try {
            $this->validateLogin($request);

            VerifyUser::AccountVerify($this->credentials($request));

            Auth::attempt($this->credentials($request), $request->has('remember'));

            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectTo);

        } catch (AuthorizationException $e) {
            $MessageBag = new MessageBag;
            $MessageBag = $MessageBag->add('AUTH', 'Неправильный логин или пароль!');
            return Redirect::back()->withInput()->withErrors($MessageBag);
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        return;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
