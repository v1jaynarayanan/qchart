<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\EmailLogin;
use Mail;
use Auth;
use App\Http\Controllers\Auth\Exception;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //Auth::guard($this->getGuard())->login($this->create($request->all()));
        $user = $this->create($request->all());
        $status = $this->sendRegistrationEmail($request);    
        return view('auth.registration_confirmation');
    }

    /**
     *  Send registration confirmation email
     *
     */
    protected function sendRegistrationEmail(Request $request)
    {

        // send off a registration confirmation email
        $emailLogin = EmailLogin::createForEmail($request->input('email'));
        
        // show the users a view saying "check your email"
        $url = route('auth.email-authenticate', [
            'token' => $emailLogin->token
        ]);

        return Mail::send('auth.emails.email-login', ['url' => $url], function ($m) use ($request) {
            $m->from('noreply@qchart.com', 'Qchart');
            $m->to($request->input('email'))->subject('Qchart - activate your account');
         });
    }


    public function authenticateEmail($token)
    {     
        $emailLogin = EmailLogin::validFromToken($token);
        $upd = EmailLogin::updateUserStatus($emailLogin->user->email);

        Auth::login($emailLogin->user);

        return redirect('/showDashboard');

    }   

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    { 
        return User::create([
            'role_id' => 0, 
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmed' => false,
            'admin' => 0,
        ]);
    }
}
