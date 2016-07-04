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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()){
            $user = Auth::user();
            $surveys = $this->getSurveysCreatedByUser();  
            return view('dashboard')->with('surveys', $surveys->simplepaginate(5));     
        }
    }

    protected function getSurveysCreatedByUser()
    {
        $userId = Auth::user()->id;
        return $surveys = DB::table('survey')
                    ->join('users', 'survey.user_id', '=', 'users.id')
                    ->select('survey.title', 'users.name', 'survey.status', 'survey.created_at', 'survey.updated_at')
                    ->where('survey.user_id', '=', $userId);
    }
}
