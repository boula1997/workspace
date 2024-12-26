<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;


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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => route('admin.login-view'), 'title'=>'Admin', 'route'=>'admin.login']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (\Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){
            // Set the recipient, subject, and body
            $to = "nessimboula@gmail.com";
            $toName = "Boula Nessim";
            $subject = 'Tasks report: Employee logged in';
            $body = '<b>this user '.$request->email.' has joined</b>';

            // Call the MailService to send the email
            $result = MailService::sendMail($to, $toName, $subject, $body);
            return redirect()->intended('/dashboard');
        }
        return redirect()->back()->with(['error' => __('general.credentials_error')]);

    }
}