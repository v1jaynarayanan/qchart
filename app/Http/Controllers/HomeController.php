<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Survey;
use App\SurveyAnswers;
use App\SurveyResponses;
use App\User;
use Auth;
use Mail;
use Log;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        if (Auth::check()){
            $surveys = $this->getSurveysCreatedByUser();

            return view('dashboard')->with('surveys', $surveys->paginate(5));     
        }
    }

    /**
     * Show survey details.
     *
     */
    public function surveyDetails($surveyId)
    {
        if (Auth::check()){
            $surveyQuestions = Survey::find($surveyId)->surveyquestions;   
            $surveyDetails = $this->getSurveyDetailsForSurvey($surveyId); 

            //get users to whom the survey was sent to
            $surveyResponses = SurveyResponses::where('survey_id', $surveyId)->get();
            $users = array();
            $sentTo = 0;
            $numOfResponses = 0;
            
            if(count($surveyResponses) > 0 ){
                foreach ($surveyResponses as $key => $value) {
                    $sentTo = $sentTo + 1;
                    if ($value->status == '1'){
                        $numOfResponses = $numOfResponses + 1;
                    }

                    $user = $this->getUserDetailsForSurvey($value->email);
                    
                    if (count($user) > 0){
                        array_push($users, $user);
                    }
                }   
            }
            //LOG::info($users);
            //LOG::info('Total users invited to fillout survey'.$sentTo);
            //LOG::info('Number of Responses'.$numOfResponses);
            return view('survey_details')->with('surveyDetails', $surveyDetails)
                                         ->with('surveyQuestions', $surveyQuestions)
                                         ->with('users', $users)
                                         ->with('sentTo', $sentTo)
                                         ->with('numOfResponses', $numOfResponses);     
        }
    }

    /*
     * Delete one or more surveys
     *
     */
    public function deleteSurvey(Request $request)
    {
         $checkBoxes = Input::get('cb');

         if (Auth::check()){
             if (isset($checkBoxes)) {
                 foreach ($checkBoxes as $key => $value) {
                    $deleteSurvey = Survey::destroy($value);
                 }
             } else {
                return Redirect::back()->with('status', 'You have not selected any survey to delete.');
             }
             
             return redirect('/home');
         }
         
    }

    /**
     * Show send survey page.
     *
     */
    public function sendSurvey($surveyId)
    {
        if (Auth::check()){
            $surveyDetails = $this->getSurveyDetailsForSurvey($surveyId);  
            return view('survey_send')->with('surveyDetails', $surveyDetails);     
        }
    }

    /*
     * Display new survey page
     *
     */
    public function showNewSurveyPage()
    {
        return view('add_new_survey');
    }

    /**
     * Close survey
     *
     */
    public function closeSurvey($surveyId)
    {
        if (Auth::check()){
            //close survey
            $survey = Survey::where('id','=',$surveyId)->update(['status' => 0]);
            
            $survey = Survey::find($surveyId);
            //LOG::info($survey->title);

            //db query to get all questions for a particular survey
            $labels = Survey::find($surveyId)->surveyquestions; 

            if (empty($labels) || count($labels) ==0 )
            {
                LOG::info('Survey closed. No survey results found for this survey. No users were informed.');

                return Redirect::back()->with('status', 'Survey closed. No survey results found for this survey. No users were informed.');
            }

            //find out how many users have answered the survey questions?
            $users = array();
            foreach ($labels as $key => $value) 
            {
                //LOG::info('SurveyQuestion'.$value->id);
                $surveyAns = SurveyAnswers::where('survey_quest_id', '=', $value->id)->get();

                $uniqueUsers = $surveyAns->unique('user_id');
                $uniqueUsers = $uniqueUsers->values()->all();
                
                if (empty($uniqueUsers) || count($uniqueUsers) ==0 )
                {
                    LOG::info('No users have answered this survey');
                    return Redirect::back()->with('status', 'No users have answered this survey. Survey Closed.');
                }

                foreach ($uniqueUsers as $key => $value) {
                    array_push($users, $value->user_id);
                }
                break;
            }

            $url = $this->createGraphLinkForEmail($surveyId);  

            foreach ($users as $key => $value) {
                $user = User::find($value);
                if(!empty($user) && !count($user) == 0){
                    $emailSent = $this->emailRequest($url, $user->email, $survey->title, $labels);
                    //LOG::info('Email sent to '. $user->email);
                }
            }

            //inform admin user
            $emailSent = $this->emailRequest($url, Auth::user()->email, $survey->title, $labels);
            //LOG::info('Email sent to Admin user');

            return redirect('/home');     
        }
    }

    protected function createGraphLinkForEmail($surveyId)
    {
        return $url = route('survey.graph', [
                    'surveyId' => $surveyId,
                ]);
    }

    public function emailRequest($url, $value, $surveyTitle, $labels)
    {
       return Mail::send('email_survey_closed', ['url' => $url, 'surveyTitle' => $surveyTitle, 'questions' => $labels], function ($m) use ($value) {
                $m->from('noreply@qchart.com', 'QChart');
                $m->to($value)->subject('QChart - Survey Closed. Please view survey results.');
        }); 
    }

    protected function getSurveysCreatedByUser()
    {
        $userId = Auth::user()->id;
        return $surveys = DB::table('survey')
                    ->join('users', 'survey.user_id', '=', 'users.id')
                    ->select('survey.id', 'survey.title', 'users.name', 'survey.status', 'survey.created_at', 'survey.updated_at')
                    ->where('survey.user_id', '=', $userId);
    }

    protected function getSurveyDetailsForSurvey($surveyId)
    {
        return DB::select('SELECT `survey`.`id` AS `survey_id`, `survey`.`title`, `survey`.`description`, `users`.`id`, `users`.`name`, `survey`.`status`, `survey`.`created_at`, `survey`.`updated_at` FROM `survey` AS `survey`, `users` AS `users` WHERE `survey`.`user_id` = `users`.`id` AND `survey`.`id` = '.$surveyId.'');            
    }   

    protected function getUserDetailsForSurvey($email){
        return $user = DB::table('users')
                    ->join('survey_responses', 'users.email', '=', 'survey_responses.email')
                    ->select('users.name', 'users.email', 'survey_responses.status')
                    ->where('survey_responses.email', '=', $email)->get();
    }
}
