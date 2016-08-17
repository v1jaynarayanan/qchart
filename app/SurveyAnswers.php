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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'survey_quest_id', 'answer', 'answered_by'
    ];

	public function surveyquestions()
    {
        return $this->belongsTo('App\SurveyQuestions', 'survey_quest_id');
    }
}
