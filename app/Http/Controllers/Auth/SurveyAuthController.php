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

class SurveyAuthController extends Controller
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
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    
    public function activeUserCompleteSurvey($surveyId, $token = null)
    {   
        LOG::info('SurveyAuthController::activeUserCompleteSurvey');
        
        //clear out any previous session
        //Session::flush();

        try
        {
            $emailLogin = EmailLogin::validFromToken($token);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) 
        {
            LOG::error('ModelNotFoundException caught when showing survey');
            return redirect('/login')->with('status', 'Unfortunately, the survey link has expired.');   
        }
        
        $upd = EmailLogin::updateUserStatus($emailLogin->user->email);

        $auth = Auth::loginUsingId($emailLogin->user->id);

        $surveyDetails = $this->getSurveyDetailsById($surveyId);

        if(empty($surveyDetails ) || count($surveyDetails) == 0) {
            LOG::error('Survey does not exist');
            return redirect('/login')->with('status', 'Unfortunately, the survey does not exist.');   
        }
        
        $questColl = $this->getSurveyQuestions($surveyId);

        return view('/activeuser_survey_complete')->with('surveyDetails',$surveyDetails)->with('surveyQuestions',$questColl)->with('surveyId', $surveyId);

    }   

    public function newUsercompleteSurvey($surveyId, $email = null)
    {   
        LOG::info('SurveyAuthController::newUsercompleteSurvey'.$surveyId);

        //clear out any previous session
        //Session::flush();
        $surveyDetails = $this->getSurveyDetailsById($surveyId);

        if(empty($surveyDetails ) || count($surveyDetails) == 0) {
            LOG::error('Survey does not exist');
            return redirect('/login')->with('status', 'Unfortunately, the survey does not exist.');   
        }

        $questColl = $this->getSurveyQuestions($surveyId);

        return view('/newuser_survey_complete')->with('surveyDetails',$surveyDetails)->with('surveyQuestions',$questColl)
            ->with('email', $email)
            ->with('surveyId', $surveyId);
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
