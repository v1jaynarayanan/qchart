<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Auth\AuthController;
use Auth;
use Mail;
use DB;
use Log;

class TemplateController extends Controller
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


    public function showNewTemplateSurveyPage($template_type)
    {
        // print_r($template_id);
        return view('add_new_survey_from_template');
    }
}
