<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Survey;
use DB;
use Illuminate\Support\Collection;

class SurveyController extends Controller
{
	/**
     * @var Role
     */
    protected $roles;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

	/**
     * Show a list of all available flights.
     *
     * @return Response
     */
    public function index()
    {
        $surveys = $this->survey->get();

        return view('admin.survey.index', compact('surveys'));
    }

    
    /**
     * Show a page of survey creation
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.survey.create');
    }

	public function draw()
	{
		
		//db query to get all questions
		$labels = DB::select('SELECT `SQ`.`question`, `SQ`.`id` FROM `survey_questions` AS `SQ`');

		//db query to get all answers for a particular survey
		
		$questColl = collect(DB::select('SELECT GROUP_CONCAT(`SQ`.`id`) AS `qid` FROM `survey_questions` AS `SQ` 
		WHERE `SQ`.`survey_id` = (SELECT `SU`.`id` FROM `survey` AS `SU`)'));

		$userColl = collect(DB::select('SELECT `id`,`name` from `users` where `role_id` != 1'));
		$labelsArr = $sgraphDataset = array();
		foreach($userColl as $ukey=>$value){
			$colourArr = array("rgba(179,181,198,0.2)", "rgba(134,194,75,0.2)", "rgba(0,255,0,0.2)");
			$fillcolor = array("rgba(114,224,13,0.5)","rgba(191,202,182,0.5)","rgba(194,114,201,0.5)");
			$highlight_fillcolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)");
			$strokecolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)");
			
			
			foreach ($labels as $k=> $lab) {
				array_push($labelsArr, $lab->question);
			}
						
			foreach($questColl as $key=> $val){				
				$answersColl = collect(DB::select('SELECT `SA`.`answer`, `SA`.`survey_quest_id` FROM `survey_answers` AS `SA` 
	WHERE `SA`.`survey_quest_id` IN ('.$val->qid.') AND `SA`.`user_id` = '.$value->id.''));
				
				foreach($answersColl as $ans){
					$ansdata[] = $ans->answer;				
				}
				
				$sgraphDataset[] = array('label'=>$value->name,
									'backgroundColor'=>$colourArr[$ukey],
									'borderColor'=>"rgba(179,181,198,1)",
									'pointBackgroundColor'=>"rgba(179,181,198,1)",
									'pointBorderColor'=>"#fff",
									'pointHoverBackgroundColor'=>"#fff",
									'pointHoverBorderColor'=>"rgba(179,181,198,1)",
									'pointHighlightFill'=> $highlight_fillcolor[$ukey],
									'fillColor' => $fillcolor[$ukey],
									'strokeColor' => $strokecolor[$ukey],
									'data'=>$ansdata);
				unset($ansdata);				
			}
		}		
		//dd($sgraphDataset);

		$viewData = array('labels'=>$labelsArr, 'datasets'=>$sgraphDataset);			
		return view('survey', ['labels'=>$labelsArr, 'datasets'=>$sgraphDataset]);
		//return $viewData;

	}
	
}