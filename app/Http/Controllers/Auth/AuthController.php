<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\EmailLogin;
use Session;
use Mail;
use Auth;
use App\Http\Controllers\Auth\Exception;
use Log;
use DB;

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
    protected $redirectTo = '/home';

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
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function authenticated(Request $request, User $user)
    {
        if ($user->confirmed) {
            return redirect()->intended($this->redirectPath());
        } else {
            Auth::logout();
            //send account verification email
            $accVerify = $this->sendAccountVerificationEmail($request);
            return Redirect::back()->with('status', 'Your account is inactive. Please activate by clicking the link sent to you by email.');
        }
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //check if user email id already exists and name is anonymous
        $email = $request->input('email');
        $name = $request->input('name');
        $pwd = $request->input('password');
        
        $user = User::where('email','=',$email)->first();

        if (!empty($user) || count($user) > 0) {
            LOG::info('User Name:'.$user->name);
            //email id already esits but check if user name is anonumous
                if('Anonymous' == $user->name){
                    LOG::info('User is anonymous');
                    $user->name=$name;
                    $user->email=$email;
                    $user->role_id = 0; 
                    $user->password = bcrypt($pwd);
                    $user->confirmed = false;
                    $user->admin = 0;
                    $user->save();
                    LOG::info('User record updated');
                    $status = $this->sendAccountVerificationEmail($request);   
                    return view('auth.registration_confirmation');
                }
                else {
                    return Redirect::back()->withInput()->withErrors(['email' => 'This email has already been taken.']);
                }
        } else {
            $user = $this->create($request->all());
            $status = $this->sendAccountVerificationEmail($request);    
            return view('auth.registration_confirmation');
        }
    }

    /**
     *  Send Account verification email
     *
     */
    public function sendAccountVerificationEmail(Request $request)
    {
        $email = $request->input('email');
        // delete any old tokens
        $oldTokens = EmailLogin::deleteOldTokens($email);

        // create new token for email 
        $emailLogin = EmailLogin::createForEmail($email);
        
        // create link to show in the email
        $url = route('auth.email-authenticate', [
            'token' => $emailLogin->token
        ]);

        //send off an account verfication email
        return Mail::send('auth.emails.email-login', ['url' => $url], function ($m) use ($request) {
            $m->from('noreply@qchart.com', 'QChart');
            $m->to($request->input('email'))->subject('QChart - activate your account');
         });
    }

    public function getUserStatus($emailId)
    {
        return DB::select('SELECT usr.confirmed FROM users usr where usr.email = :emailId', ['emailId' => $emailId]);
    }

    public function authenticateEmail($token)
    {     
        try
        {
            $emailLogin = EmailLogin::validFromToken($token);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) 
        {
            LOG::error('ModelNotFoundException caught');
            return redirect('/login')->with('status', 'Your account is inactive. Fill out your email id and password and click login to resend your acccount activation link by email');   
        }

        $upd = EmailLogin::updateUserStatus($emailLogin->user->email);

        $auth = Auth::loginUsingId($emailLogin->user->id);

        return redirect('/home');      
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
