<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use App\Survey;
use App\SurveyQuestions;
use App\EmailLogin;
use Validator;
use Auth;
use Mail;
use DB;
use Log;

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

	public function drawGraph($surveyId)
	{
		//db query to get all questions
		$labels = DB::select('SELECT `SQ`.`question`, `SQ`.`id` FROM `survey_questions` AS `SQ` WHERE `SQ`.`survey_id` ='.$surveyId.'');

		$labelsArr = $sgraphDataset = $ansdata = array();
		if (empty($labels)){
			LOG::info('No questions for survey');
			return Redirect::back()->with('status', 'No questions found for survey. Unable to generate graph.');
		}

		foreach ($labels as $k=> $lab) {
			array_push($labelsArr, $lab->question);
		}

		$questColl = collect(DB::select('SELECT GROUP_CONCAT(`SQ`.`id`) AS `qid` FROM `survey_questions` AS `SQ` WHERE `SQ`.`survey_id` in (SELECT `SU`.`id` FROM `survey` AS `SU` WHERE `SU`.`id` = '.$surveyId.')'));

		//$userColl = collect(DB::select('SELECT `id`,`name` from `users` where `id` != '.Auth::user()->id));
		$userColl = collect(DB::select('SELECT `id`,`name` from `users`'));

		$colourArr = array("rgba(179,181,198,0.2)", "rgba(134,194,75,0.2)", "rgba(0,255,0,0.2)","rgba(120,140,198,0.2)","rgba(150,200,50,0.2)", "rgba(210,130,175,0.2)", "rgba(176,122,135,0.2)", "rgba(110,202,169,0.2)");
		$fillcolor = array("rgba(114,224,13,0.5)","rgba(191,202,182,0.5)","rgba(194,114,201,0.5),rgba(124,204,23,0.5)","rgba(150,75,140,0.5)","rgba(150,144,180,0.5)","rgba(178,50,90,0.5)","rgba(190,120,230,0.5)");
		$highlight_fillcolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)","rgba(54,124,63,1)","rgba(150,100,204,1)","rgba(99,140,220,1)","rgba(185,120,104,1)","rgba(199,40,120,1)");
		$strokecolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)","rgba(74,124,53,1)","rgba(91,122,202,1)","rgba(194,104,181,1)");

		//get answers for survey questions answered by non admin users
		foreach($userColl as $ukey=>$value){		
			foreach($questColl as $key=> $val){		
				//db query to get all answers for a particular survey		
				$answersColl = collect(DB::select('SELECT `SA`.`answer`, `SA`.`survey_quest_id` FROM `survey_answers` AS `SA` WHERE `SA`.`survey_quest_id` IN ('.$val->qid.') AND `SA`.`user_id` = '.$value->id.''));
				
				if (empty($answersColl)){
					LOG::info('No answers for survey');
					return Redirect::back()->with('status', 'No answers found for survey. Unable to generate graph.');
				}
	
				foreach($answersColl as $ans){
					$ansdata[] = $ans->answer;	
				}
				
				if(!empty($ansdata))
				{
					//generate chart data
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
		}		

		//creaete aggregated dataset
		$aggregateData = $this->aggregateData($sgraphDataset);
		array_push($sgraphDataset, $aggregateData);
		LOG::info(print_r($sgraphDataset, true));

		//$viewData = array('labels'=>$labelsArr, 'datasets'=>$sgraphDataset);			
		return view('survey_graph', ['labels'=>$labelsArr, 'datasets'=>$sgraphDataset]);

	}
	
	protected function aggregateData($sgraphDataset)
	{
		LOG::info('aggregateData');
		$q0=0;$q1=0;$q2=0;$q3=0;
		$q4=0;$q5=0;$q6=0;$q7=0;
		$i=0;
    	Log::info(print_r($sgraphDataset, true));
    	LOG::info('First Loop '.$i); 
    		foreach ($sgraphDataset as $gkey => $gvalue) 
    		{
    			LOG::info('Second Loop '.$gkey);
    			LOG::info(print_r($gvalue,true));
    			foreach ($gvalue as $skey => $svalue) 
    			{
    				LOG::info('Second Loop '.$skey);
	    			if($skey == 'data')
	    			{
	    				LOG::info('found data'); 
	    				$data = array();
	    				$data[] = $svalue;
	    				LOG::info('get data'); 
	    				foreach ($data as $dkey => $dvalue) 
	    				{
	    					Log::info(print_r($dvalue, true));
	    					foreach ($dvalue as $key => $value) 
	    					{
	    						if($key == '0')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q0 += $value;
	    							//break;	
	    						}
	    						if($key == '1')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q1 += $value;
	    							//break;	
	    						}
	    						if($key == '2')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q2 += $value;
	    							//break;	
	    						}
	    						if($key == '3')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q3 += $value;
	    							//break;	
	    						}
	    						if($key == '4')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q4 += $value;
	    							//break;	
	    						}
	    						if($key == '5')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q5 += $value;
	    							//break;	
	    						}
	    						if($key == '6')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q6 += $value;
	    							//break;	
	    						}
	    						if($key == '7')
	    						{
									LOG::info('ans=>'.$value); 
	    							$q7 += $value;
	    							//break;	
	    						}
	    						//break;
	    					}
	    					//break;
	    				}
	    			}
    			 } 
    			 $i++;
    		}
    	LOG::info('Divide by'.$i);
    	LOG::info($q0/$i);
    	LOG::info($q1/$i);
    	LOG::info($q2/$i);
    	LOG::info($q3/$i);
    	LOG::info($q4/$i);
    	LOG::info($q5/$i);
    	LOG::info($q6/$i);
    	LOG::info($q7/$i);
    	
    	$ansdata = array();
    	array_push($ansdata,$q0/$i);
    	array_push($ansdata,$q1/$i);
    	array_push($ansdata,$q2/$i);
    	array_push($ansdata,$q3/$i);
    	array_push($ansdata,$q4/$i);
    	array_push($ansdata,$q5/$i);
    	array_push($ansdata,$q6/$i);
    	array_push($ansdata,$q7/$i);

    	return array('label'=>"Aggregate",
						 'backgroundColor'=>"rgba(134,194,75,0.2)",
						 'borderColor'=>"rgba(179,181,198,1)",
						 'pointBackgroundColor'=>"rgba(179,181,198,1)",
						 'pointBorderColor'=>"#fff",
				   	 'pointHoverBackgroundColor'=>"#fff",
		  				 'pointHoverBorderColor'=>"rgba(179,181,198,1)",
		 				 'pointHighlightFill'=> "rgba(101,202,182,1)",
		 				 'fillColor' => "rgba(101,202,182,0.5)",
						 'strokeColor' => "rgba(101,202,182,1)",
		 				 'data'=>$ansdata);
	}

	public function sendSurveyEmail(Request $request)
	{
		$email = $request->input('email');
		$surveyId = $request->input('surveyId');
		
		$emailIds = explode(',', $email);

		$validator = $this->validator($request->all());

       	if ($validator->fails()) {
           	return Redirect::back()->withInput()->with('status', 'Invalid email id entered');

       	}

		$authController = new AuthController();
		
		foreach ($emailIds as $key => $value) {

			$userStatusArr = $authController->getUserStatus($value);

			$userStatus=null;
			foreach ($userStatusArr as $skey => $svalue) {
				$userStatus = $svalue->confirmed;
			}
			
    		LOG::info('User status'.$userStatus);
			if (!empty($userStatus) && $userStatus == 1) {

				LOG::info('Active User');
        		$oldTokens = EmailLogin::deleteOldTokens($email);
				$emailLogin = EmailLogin::createForEmail($email);
				$url = $this->createLinkForEmail($surveyId, $emailLogin->token, null);	

       			$emailSent = $this->emailRequest($url, $value);
			}
			else {
				
				$url = $this->createLinkForEmail($surveyId, null, $value);	

       			$emailSent = $this->emailRequest($url, $value);
			}
			
		}
		return view('survey_email_confirmation');
	}

	public function createLinkForEmail($surveyId, $token, $email)
	{
		if(!empty($token)){
			return $url = route('activeuser.survey.complete', [
            		'surveyId' => $surveyId,
            		'token' => $token,
        		]);	
		} else {
			return $url = route('newuser.survey.complete', [
       				'surveyId' => $surveyId,
       				'email' => $email,
        		]);
		}
		
	}

	public function emailRequest($url, $value)
	{
       return Mail::send('email_survey_complete', ['url' => $url], function ($m) use ($value) {
            	$m->from('noreply@qchart.com', 'QChart');
            	$m->to($value)->subject('QChart - Please complete survey');
       	});	
	}

	public function createNewSurvey(Request $request)
	{
		$title = $request->input('surveyTitle');
		$desc = $request->input('surveyDescription');
		$q1 = $request->input('question1');
		$q2 = $request->input('question2');
		$q3 = $request->input('question3');
		$q4 = $request->input('question4');
		$q5 = $request->input('question5');
		$q6 = $request->input('question6');
		$q7 = $request->input('question7');
		$q8 = $request->input('question8');	
		$num_ques = 8;

		if (Auth::check()){
			if(!empty($q1) || !empty($q2) || !empty($q3) || !empty($q4) || !empty($q5) ||
				!empty($q6) || !empty($q7) || !empty($q8)){
				if(!empty($title) && !empty($desc)){
					
					//create survey
					$survey = new Survey();
					$survey = $this->saveNewSurvey($title, $desc);

					//create questions for the survey
					for($i = 1;$i<=$num_ques;$i++)
					{
    					if(!empty('q'.$i)){
							$surveyQuestion = $this->saveNewQuestion($request->input('question'.$i),$survey);
						}
					}
				}
			}
        }	
		return view('new_survey_confirmation');
	}

	protected function saveNewSurvey($title, $desc)
	{
			$survey = new Survey();
			$survey->user_id = Auth::user()->id;
			$survey->title = $title;
			$survey->slug = $title;
			$survey->description = $desc;
			$survey->status = 1;
			$survey->save();
			return $survey;	
	}

	protected function saveNewQuestion($question, $survey)
	{
			$surveyQuestion = new SurveyQuestions();
			$surveyQuestion->user_id = Auth::user()->id;
			$surveyQuestion->question = $question;
			$survey->surveyquestions()->save($surveyQuestion);
			return $surveyQuestion;

	}

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255'
        ]);
    }

	

}