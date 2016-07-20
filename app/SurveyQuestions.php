<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SurveyAnswers;

class SurveyQuestions extends Model {
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_questions';

    /**
     * Get the Survey Answers for the Survey Question.
     */
    public function surveyanswers()
    {
        return $this->hasMany('App\SurveyAnswers');
    }

}
