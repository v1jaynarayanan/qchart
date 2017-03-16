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

    public function showPreviewTemplateSurveyPage($template_type)
    {

        try {

            $template_type = str_replace("-", "_", $template_type);

            return view('survey_preview_templates.' . $template_type);

        } catch (\Exception $e) {
            abort(404);
        }

    }

}
