<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SurveyAnswers;
use App\Survey;

class SurveyQuestions extends Model {
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_questions';

    public function survey()
    {
        return $this->belongsTo('App\Survey', 'survey_id');
    }

    /**
     * Get the Survey Answers for the Survey Question.
     */
    public function surveyanswers()
    {
        return $this->hasMany('App\SurveyAnswers');
    }

}
