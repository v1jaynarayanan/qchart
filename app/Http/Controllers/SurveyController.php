<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Survey;
use App\SurveyQuestions;
use App\SurveyAnswers;
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
		//db query to get all questions for a particular survey
		$labels = Survey::find($surveyId)->surveyquestions;	
		
		if (empty($labels) || count($labels) == 0 ){
			LOG::info('No questions for survey');
			return Redirect::back()->with('status', 'No questions found for survey. Unable to generate graph.');
		}

		$labelsArr = $sgraphDataset = $ansdata = array();
		//get the questions for graph display
		foreach ($labels as $k=> $lab) {
			array_push($labelsArr, $lab->question);
		}

		//get the question ids
		$questColl = $labels->implode('id',',');
		//LOG::info(print_r($questColl, true));

		$colourArr = array("rgba(179,181,198,0.2)", "rgba(134,194,75,0.2)", "rgba(0,255,0,0.2)","rgba(120,140,198,0.2)","rgba(150,200,50,0.2)", "rgba(210,130,175,0.2)", "rgba(176,122,135,0.2)", "rgba(110,202,169,0.2)");
		$fillcolor = array("rgba(114,224,13,0.5)","rgba(191,202,182,0.5)","rgba(194,114,201,0.5),rgba(124,204,23,0.5)","rgba(150,75,140,0.5)","rgba(150,144,180,0.5)","rgba(178,50,90,0.5)","rgba(190,120,230,0.5)");
		$highlight_fillcolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)","rgba(124,204,23,1)","rgba(150,75,140,1)","rgba(99,140,220,1)","rgba(178,50,90,1)","rgba(90,120,230,1)");
		$strokecolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)","rgba(124,204,23,1)","rgba(178,50,90,1)","rgba(90,120,230,1)");

		//find out how many users have answered the survey questions?
		$users = array();
		foreach ($labels as $key => $value) 
		{
			//LOG::info('SurveyQuestion'.$value->id);
			$surveyAns = SurveyAnswers::where('survey_quest_id', '=', $value->id)->get();

			$uniqueUsers = $surveyAns->unique('user_id');
			$uniqueUsers = $uniqueUsers->values()->all();
			
			if (empty($uniqueUsers) || count($uniqueUsers) ==0 )
			{
				LOG::info('No answers for survey');
			    return Redirect::back()->with('status', 'No answers found for survey. Unable to generate graph.');
			}

			foreach ($uniqueUsers as $key => $value) {
				array_push($users, $value->user_id);
			}
			break;
		}
		
		//get the user id and names for all users who have answered the survey
		$userColl = collect(DB::select('SELECT `id`,`name` from `users` where `id` in ('.collect($users)->implode(',').')'));
		//LOG::info(print_r($userColl, true));
		

		$noAnswers = true;
		//get answers for survey questions answered by users
		foreach($userColl as $ukey=>$value){		
			//db query to get all answers for a particular survey		
				$answersColl = collect(DB::select('SELECT `SA`.`answer`, `SA`.`survey_quest_id` FROM `survey_answers` AS `SA` WHERE `SA`.`survey_quest_id` IN ('.$questColl.') AND `SA`.`user_id` = '.$value->id.''));
				
				if (!empty($answersColl) || count($answersColl) != 0)
				{

					foreach($answersColl as $ans)
					{
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
						$noAnswers = false;
					}	
				}	
		}	

		if ($noAnswers == true)
		{
			LOG::info('No answers for survey');
			return Redirect::back()->with('status', 'No answers found for survey. Unable to generate graph.');
		}

		//create aggregated dataset
		$aggregateData = $this->aggregateData($sgraphDataset);
		array_push($sgraphDataset, $aggregateData);
		//LOG::info(print_r($sgraphDataset, true));

		/*
		$showSgraphDataset = array();
		if (count($sgraphDataset) > 2) {
			LOG::info('Dataset > 2');
			$showSgraphDataset = array_slice($sgraphDataset, 0, 2);
			//array_push($showSgraphDataset, $trucSgraphDataset);
			LOG::info(print_r($showSgraphDataset, true));
		}
		array_push($showSgraphDataset, $aggregateData);
		LOG::info(print_r($showSgraphDataset, true));
		*/

		return view('survey_graph', ['labels'=>$labelsArr, 'datasets'=>$sgraphDataset]);

	}
	
	protected function aggregateData($sgraphDataset)
	{
		$q0=0;$q1=0;$q2=0;$q3=0;
		$q4=0;$q5=0;$q6=0;$q7=0;
		$i=0;
    	//Log::info(print_r($sgraphDataset, true));
    		foreach ($sgraphDataset as $gkey => $gvalue) 
    		{
    			foreach ($gvalue as $skey => $svalue) 
    			{
	    			if($skey == 'data')
	    			{
	    				$data = array();
	    				$data[] = $svalue;
	    				foreach ($data as $dkey => $dvalue) 
	    				{
	    					//Log::info(print_r($dvalue, true));
	    					foreach ($dvalue as $key => $value) 
	    					{
	    						if($key == '0')
	    						{
	    							$q0 += $value;
	    						}
	    						if($key == '1')
	    						{
	    							$q1 += $value;
	    						}
	    						if($key == '2')
	    						{
	    							$q2 += $value;
	    						}
	    						if($key == '3')
	    						{
	    							$q3 += $value;
	    						}
	    						if($key == '4')
	    						{
	    							$q4 += $value;
	    						}
	    						if($key == '5')
	    						{
									$q5 += $value;
	    						}
	    						if($key == '6')
	    						{
									$q6 += $value;
	    						}
	    						if($key == '7')
	    						{
	    							$q7 += $value;	
	    						}
	    					}
	    				}
	    			}
    			 } 
    			 $i++;
    		}
    	
    	$ansdata = array();
    	if($q0 > 0){
    		array_push($ansdata,$q0/$i);
    	}
    	if($q1 > 0){
    		array_push($ansdata,$q1/$i);
    	}
    	if($q2 > 0){
    		array_push($ansdata,$q2/$i);
    	}
    	if($q3 > 0){
    		array_push($ansdata,$q3/$i);
    	}
    	if($q4 > 0){
    		array_push($ansdata,$q4/$i);
    	}
    	if($q5 > 0){
    		array_push($ansdata,$q5/$i);
    	}
    	if($q6 > 0){
    		array_push($ansdata,$q6/$i);
    	}
    	if($q7 > 0){
    		array_push($ansdata,$q7/$i);
    	}
    
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

		foreach($emailIds as $email) 
		{
    		$validator = Validator::make(
      		 	['email' => $email],
        		['email' => 'required|email']
    		);
    		
	    	if ($validator->fails())
	    	{
	    		LOG::ERROR('invalid email '.$email);
	     		return Redirect::back()->withInput()->with('status', 'Invalid email id entered');
	    	}
		}

		$authController = new AuthController();
		
		foreach ($emailIds as $key => $value) {

			$userStatusArr = $authController->getUserStatus($value);

			$userStatus=null;
			foreach ($userStatusArr as $skey => $svalue) {
				$userStatus = $svalue->confirmed;
			}

			if (!empty($userStatus) && $userStatus == 1) {

				LOG::info('Active User');
				$oldTokens = EmailLogin::deleteOldTokens($value);
				$emailLogin = EmailLogin::createForEmail($value);
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
					if(!empty($q1)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question1'),$survey);
					}
					if(!empty($q2)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question2'),$survey);
					}
					if(!empty($q3)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question3'),$survey);
					}
					if(!empty($q4)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question4'),$survey);
					}
					if(!empty($q5)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question5'),$survey);
					}
					if(!empty($q6)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question6'),$survey);
					}
					if(!empty($q7)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question7'),$survey);
					}
					if(!empty($q8)){
						$surveyQuestion = $this->saveNewQuestion($request->input('question8'),$survey);
					}
				}
			}
        }	
        return view('new_survey_confirmation')->with('surveyDetails', $survey);
	}

	public function activeUserSurveyResponse(Request $request)
    {
        //LOG::info('in activeUserSurveyResponse');
        $answer = $request->input('answer');
        $q1 = $request->input('question1');
		$q2 = $request->input('question2');
		$q3 = $request->input('question3');
		$q4 = $request->input('question4');
		$q5 = $request->input('question5');
		$q6 = $request->input('question6');
		$q7 = $request->input('question7');
		$q8 = $request->input('question8');	
		
        $i=0;
        $ans1=0;$ans2=0;$ans3=0;$ans4=0;
        $ans5=0;$ans6=0;$ans7=0;$ans8=0;
        foreach ($answer as $key => $value) {
        	if($i == 0){
        		$ans1 = $value;
            }
        	if($i == 1){
        		$ans2 = $value;
        	}
        	if($i == 2){
        		$ans3 = $value;
        	}
        	if($i == 3){
        		$ans4 = $value;
        	}
        	if($i == 4){
        		$ans5 = $value;
        	}
        	if($i == 5){
        		$ans6 = $value;
        	}
        	if($i == 6){
        		$ans7 = $value;
        	}
        	if($i == 7){
        		$ans8 = $value;
        	}
        	$i++;
        }

  		//check if user has already answered the survey
  		$alreadyAnswered = SurveyAnswers::where('user_id','=',Auth::user()->id)
  						  			    ->where('survey_quest_id','=',$q1)->get();
  		//LOG::info($alreadyAnswered); 
  		if(!empty($alreadyAnswered) && count($alreadyAnswered) != 0) {
  			LOG::error('User has already submitted a response for this survey.');
  			return Redirect::back()->withInput()->with('status', 'You have already submitted your response.');
  		}
  		
  		$userId = Auth::user()->id;
		if(!empty($q1) || count($q1) != 0){
			LOG::info('Survey Ans1 '.$ans1);
			$surveyAns = $this->createAnswer($userId, $q1, $ans1);
		}
		if(!empty($q2) || count($q2) != 0){
			LOG::info('Survey Ans2 '.$ans2);
			$surveyAns = $this->createAnswer($userId, $q2, $ans2);
		}
		if(!empty($q3) || count($q3) != 0){
			//LOG::info('Survey Ans3 ');
			$surveyAns = $this->createAnswer($userId, $q3, $ans3);
		}
		if(!empty($q4) || count($q4) != 0){
			$surveyAns = $this->createAnswer($userId, $q4, $ans4);	
		}
		if(!empty($q5) || count($q5) != 0){
			$surveyAns = $this->createAnswer($userId, $q5, $ans5);	
		}
		if(!empty($q6) || count($q6) != 0){
			$surveyAns = $this->createAnswer($userId, $q6, $ans6);	
		}
		if(!empty($q7) || count($q7) != 0){
			$surveyAns = $this->createAnswer($userId, $q7, $ans7);	
		}
		if(!empty($q8) || count($q8) != 0){
			LOG::info('Survey Ans8 '.$ans8);
			$surveyAns = $this->createAnswer($userId, $q8, $ans8);	
		}

		return view('survey_response_confirmation');
		
    }

    public function newUserSurveyResponse(Request $request)
    {
        //LOG::info('in newUserSurveyResponse');
        $answer = $request->input('answer');
        $q1 = $request->input('question1');
		$q2 = $request->input('question2');
		$q3 = $request->input('question3');
		$q4 = $request->input('question4');
		$q5 = $request->input('question5');
		$q6 = $request->input('question6');
		$q7 = $request->input('question7');
		$q8 = $request->input('question8');	
		$name = $request->input('name');
		$email = $request->input('email');
		
		if(empty($name) || count($name) == 0 ) {
			LOG::info('Name is Anonymous');
			$name = 'Anonymous';
		}

		$validator = Validator::make(
      		 	['email' => $email],
        		['email' => 'required|email']
    		);
    		
	    	if ($validator->fails())
	    	{
	    		LOG::ERROR('invalid email '.$email);
	    		return Redirect::back()->withInput()->with('status', 'Invalid email id entered');
	    	}

		//check if the user exists already
		$user = User::where('email', $email)->get();
		//LOG::info('User'.$user);
		$userId=null;
		
		if(empty($user) || count($user) ==0) {
			//register user
			$user = new User();
			$user->role_id=0;
			$user->name=$name;
			$user->email=$email;
			$user->confirmed=0;
			$user->admin=0;
			$user->save();	
			$userId=$user->id;
			LOG::info('New user created'.$userId);
		} else {
			foreach ($user as $key => $value) {
				$userId = $value->id;
				if (!empty($name) && count($name) > 0 && $name != 'Anonymous'){
					$existingUser = User::where('email','=',$value->email)->first();
					LOG::info('Update user name from Anonymous to '.$name);
					$existingUser->name = $name;
					$existingUser->save();
				} else {
					LOG::info('User name provided is Anonymous');
				}
			
			}
		}

        $i=0;
        $ans1=0;$ans2=0;$ans3=0;$ans4=0;
        $ans5=0;$ans6=0;$ans7=0;$ans8=0;
        foreach ($answer as $key => $value) {
        	//LOG::info('Value'.$value);
        	//LOG::info('i'.$i);
        	if($i == 0){
        		$ans1 = $value;
            }
        	if($i == 1){
        		$ans2 = $value;
        	}
        	if($i == 2){
        		$ans3 = $value;
        	}
        	if($i == 3){
        		$ans4 = $value;
        	}
        	if($i == 4){
        		$ans5 = $value;
        	}
        	if($i == 5){
        		$ans6 = $value;
        	}
        	if($i == 6){
        		$ans7 = $value;
        	}
        	if($i == 7){
        		$ans8 = $value;
        	}
        	$i++;
        }
        
  		//check if user already has anwered the questions
  		$alreadyAnswered = SurveyAnswers::where('user_id','=',$userId)
  					 	                ->where('survey_quest_id','=',$q1)->get();
  		//LOG::info($alreadyAnswered); 
  		if(!empty($alreadyAnswered) && count($alreadyAnswered) != 0) {
  			LOG::error('User has already submitted a response for this survey.');
  			return Redirect::back()->withInput()->with('status', 'You have already submitted your response.');
  		}

		if(!empty($q1) || count($q1) != 0){
			//LOG::info('Survey Ans1 ');
			$surveyAns = $this->createAnswer($userId, $q1, $ans1);
		}
		if(!empty($q2) || count($q2) != 0){
			//LOG::info('Survey Ans2 ');
			$surveyAns = $this->createAnswer($userId, $q2, $ans2);
		}
		if(!empty($q3) || count($q3) != 0){
			//LOG::info('Survey Ans3 ');
			$surveyAns = $this->createAnswer($userId, $q3, $ans3);
		}
		if(!empty($q4) || count($q4) != 0){
			$surveyAns = $this->createAnswer($userId, $q4, $ans4);	
		}
		if(!empty($q5) || count($q5) != 0){
			$surveyAns = $this->createAnswer($userId, $q5, $ans5);
		}
		if(!empty($q6) || count($q6) != 0){
			$surveyAns = $this->createAnswer($userId, $q6, $ans6);
		}
		if(!empty($q7) || count($q7) != 0){
			$surveyAns = $this->createAnswer($userId, $q7, $ans7);	
		}
		if(!empty($q8) || count($q8) != 0){
			$surveyAns = $this->createAnswer($userId, $q8, $ans8);
		}
		
		return view('survey_response_confirmation');
    }

    protected function createAnswer($userId, $question, $answer)
    {
    	$surveyAnswers = new SurveyAnswers();
		$surveyAnswers->user_id = $userId;
		$surveyAnswers->survey_quest_id = $question;
		$surveyAnswers->answer = $answer;	
		$surveyAnswers->save();	
		return $surveyAnswers;
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

	protected function validator(array $emailIds)
    {
    	foreach($emailIds as $email) 
		{
    		$validator = Validator::make(
      		 	['email' => $email],
        		['email' => 'required|email']
    		);
    		
	    	if ($validator->fails())
	    	{
	    		return Redirect::back()->withInput()->with('status', 'Invalid email id entered');
	    	}
		}
    }

	

}