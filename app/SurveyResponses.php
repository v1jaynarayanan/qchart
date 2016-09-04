<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponses extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_id', 'email', 'status'
    ];

    public function surveyresponses()
    {
        return $this->belongsTo('App\Survey', 'survey_id');
    }
}
