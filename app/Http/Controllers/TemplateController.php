<?php

namespace App\Http\Controllers;

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

        try
        {
            $template_type = str_replace("-", "_", $template_type);
            return view('survey_templates.' . $template_type);
        } catch (\Exception $e) {
            abort(404);
        }

    }
}
