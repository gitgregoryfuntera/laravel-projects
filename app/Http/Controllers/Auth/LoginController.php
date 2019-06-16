<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;



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
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login() 
    {
        $user = request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if(!$token = auth()->attempt($user))
        {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return response()->json([
            'user' => request()->user(),
            'token' => $token
        ]);
    }

    public function logout() 
    {
       Auth::logout();
 
        return response()->json([
            'message' => 'Logged Out!'
        ]);
    }
}
