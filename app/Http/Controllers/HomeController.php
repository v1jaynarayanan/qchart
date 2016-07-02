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
            LOG::info('user not null. show dash');
            $user = Auth::user();
            LOG::info($user);
            $surveys = $this->getSurveysCreatedByUser();  
            return view('dashboard')->with('surveys', $surveys);     
        }
    }

    protected function getSurveysCreatedByUser()
    {
        return DB::select('SELECT title, status, created_at, updated_at FROM Survey WHERE user_id = :id', ['id' => Auth::user()->id]);
    }
}
