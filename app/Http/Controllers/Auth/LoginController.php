<?php

namespace SiGeEdu\Http\Controllers\Auth;

use Illuminate\Http\Request;
use SiGeEdu\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use SiGeEdu\Models\Administrator;

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
        $this->redirectTo = route('admin.dashboard');
        $this->middleware('guest')->except('logout');
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
     * Get the needed authorization credentials from the request.
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $usernameKey = $this->usernameKey($request);

        $data = $request->only($this->username(), 'password');
        $data[$usernameKey] = $data[$this->username()];
        $data['userable_type'] = Administrator::class;
        unset($data[$this->username()]);

        return $data;
    }

    /**
     * Get the usernameKey from the request.
     * @param Request $request
     * @return string
     */
    protected function usernameKey(Request $request){
        $email = $request->get($this->username());
        $validator = \Validator::make([
            'email' => $email
        ],[
            'email' => 'email'
        ]);

        return $validator->fails() ? 'enrolment' : 'email';
    }
}
