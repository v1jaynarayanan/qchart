<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model {
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description','status',
    ];

}
