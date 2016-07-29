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
            'email' => 'required|email|max:255|unique:users',
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
            return Redirect::back()->with('status', 'Your account is inactive. Please activate by clicking the link sent to you by email');
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

        $user = $this->create($request->all());
        $status = $this->sendAccountVerificationEmail($request);    
        return view('auth.registration_confirmation');
    }

    /**
     *  Send Account verification email
     *
     */
    protected function sendAccountVerificationEmail(Request $request)
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

    public function activeUserCompleteSurvey($surveyId, $token = null)
    {   
        LOG::info('activeUserCompleteSurvey');
        
        try
        {
            $emailLogin = EmailLogin::validFromToken($token);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) 
        {
            LOG::error('ModelNotFoundException caught when showing survey');
            return redirect('/login')->with('status', 'Unfortunately, the survey is now closed');   
        }
        
        $upd = EmailLogin::updateUserStatus($emailLogin->user->email);

        $auth = Auth::loginUsingId($emailLogin->user->id);

        $surveyDetails = $this->getSurveyDetailsById($surveyId);

        $questColl = $this->getSurveyQuestions($surveyId);

        return view('/activeuser_survey_complete')->with('surveyDetails',$surveyDetails)->with('surveyQuestions',$questColl);

    }   

    public function newUsercompleteSurvey($surveyId, $email = null)
    {   
        LOG::info('newUsercompleteSurvey'.$surveyId);

        $surveyDetails = $this->getSurveyDetailsById($surveyId);

        $questColl = $this->getSurveyQuestions($surveyId);

        return view('/newuser_survey_complete')->with('surveyDetails',$surveyDetails)->with('surveyQuestions',$questColl);
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

    protected function getSurveyDetailsById($surveyId)
    {
        return DB::select('SELECT `survey`.`id` AS `survey_id`, `survey`.`title`, `survey`.`description`, `users`.`id`, `users`.`name`, `survey`.`status`, `survey`.`created_at`, `survey`.`updated_at` FROM `survey` AS `survey`, `users` AS `users` WHERE `survey`.`user_id` = `users`.`id` AND `survey`.`id` = '.$surveyId.'');            
    } 

    protected function getSurveyQuestions($surveyId) 
    {
        return collect(DB::select('SELECT `SQ`.`id` AS `qid`, `SQ`.`question` AS `question` FROM `survey_questions` AS `SQ` WHERE `SQ`.`survey_id` in (SELECT `SU`.`id` FROM `survey` AS `SU` WHERE `SU`.`id` = '.$surveyId.')'));

    } 
}
