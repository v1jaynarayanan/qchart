<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SurveyQuestions;

class SurveyAnswers extends Model {
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_answers';

	public function surveyquestions()
    {
        return $this->belongsTo('App\SurveyQuestions', 'survey_quest_id');
    }
}
