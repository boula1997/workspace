<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;
use App\Models\Followup;
use App\Models\Admin;


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
            // Fetch follow-up titles with phone and without phone
            $followupsWithPhone = Followup::where('hasPhone', 1)->distinct()->pluck('title');
            $followupsWithoutPhone = Followup::where('hasPhone', 0)->distinct()->pluck('title');

            // Set the recipient, subject, and body
            $to = "nessimboula@gmail.com";
            $toName = "Boula Nessim";
            $subject = 'Tasks report: Employee has joined';

            // Start building the email body
            $body = '<b>The user ' . $request->email . ' has joined</b><br><br>';
            $body .= '<h3>Follow-ups with phone:</h3>';
            $body .= '<ul>';

            // Add links for follow-ups with phone
            foreach ($followupsWithPhone as $followup) {
                $body .= '<li><a href="' . $followup . '">' . htmlspecialchars($followup) . '</a></li>';
            }

            $body .= '</ul><br>';

            $body .= '<h3>Follow-ups without phone:</h3>';
            $body .= '<ul>';

            // Add links for follow-ups without phone
            foreach ($followupsWithoutPhone as $followup) {
                $body .= '<li><a href="' . $followup . '">' . htmlspecialchars($followup) . '</a></li>';
            }

            $body .= '</ul>';
            
            // Send the email using MailService
            $admins=Admin::get();
            foreach($admins as $admin){
                if($admin->email=="nessimboula@gmail.com")
                $result = MailService::sendMail($admin->email, $toName, $subject, $body);
            }
            return redirect()->intended('/dashboard');
        }
        return redirect()->back()->with(['error' => __('general.credentials_error')]);

    }
}