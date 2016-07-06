<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Survey;
use Auth;
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
            $surveyDetails = $this->getSurveyDetailsForSurvey($surveyId);  
            return view('survey_details')->with('surveyDetails', $surveyDetails);     
        }
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
