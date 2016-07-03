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
            return view('dashboard')->with('surveys', $surveys);     
        }
    }

    protected function getSurveysCreatedByUser()
    {
        return DB::select('SELECT s.title, usr.name, s.status, s.created_at, s.updated_at  FROM survey s, users usr WHERE s.user_id = usr.id AND s.user_id = :id', ['id' => Auth::user()->id]);
    }
}
