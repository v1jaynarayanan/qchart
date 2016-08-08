<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Survey;
use App\SurveyAnswers;
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
            return view('survey_details')->with('surveyDetails', $surveyDetails)
                                         ->with('surveyQuestions', $surveyQuestions);     
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
            
            //LOG::info('Admin users email'.Auth::user()->email);
            //LOG::info('Users who have answered this survey');
            //LOG::info(print_r($users, true));

            $url = $this->createGraphLinkForEmail($surveyId);  

            foreach ($users as $key => $value) {
                $user = User::find($value);
                if(!empty($user) && !count($user) == 0){
                    $emailSent = $this->emailRequest($url, $user->email, $survey->title);
                    //LOG::info('Email sent to '. $user->email);
                }
            }

            //inform admin user
            $emailSent = $this->emailRequest($url, Auth::user()->email, $survey->title);
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

    public function emailRequest($url, $value, $surveyTitle)
    {
       return Mail::send('email_survey_closed', ['url' => $url, 'surveyTitle' => $surveyTitle], function ($m) use ($value) {
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
}
