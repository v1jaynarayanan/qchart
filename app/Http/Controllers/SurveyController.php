<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use App\Survey;
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
			return Redirect::back()->with('status', 'No questions or answers found for survey. Unable to generate graph.');
		}

		foreach ($labels as $k=> $lab) {
			array_push($labelsArr, $lab->question);
		}

		$questColl = collect(DB::select('SELECT GROUP_CONCAT(`SQ`.`id`) AS `qid` FROM `survey_questions` AS `SQ` WHERE `SQ`.`survey_id` in (SELECT `SU`.`id` FROM `survey` AS `SU` WHERE `SU`.`id` = '.$surveyId.')'));

		$userColl = collect(DB::select('SELECT `id`,`name` from `users` where `role_id` != 0'));


		$colourArr = array("rgba(179,181,198,0.2)", "rgba(134,194,75,0.2)", "rgba(0,255,0,0.2)");
		$fillcolor = array("rgba(114,224,13,0.5)","rgba(191,202,182,0.5)","rgba(194,114,201,0.5)");
		$highlight_fillcolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)");
		$strokecolor = array("rgba(114,224,13,1)","rgba(191,202,182,1)","rgba(194,114,201,1)");

		//get answers for survey questions answered by non admin users
		foreach($userColl as $ukey=>$value){					
			foreach($questColl as $key=> $val){		
				//db query to get all answers for a particular survey		
				$answersColl = collect(DB::select('SELECT `SA`.`answer`, `SA`.`survey_quest_id` FROM `survey_answers` AS `SA` WHERE `SA`.`survey_quest_id` IN ('.$val->qid.') AND `SA`.`user_id` = '.$value->id.''));
				
				foreach($answersColl as $ans){
					$ansdata[] = $ans->answer;				
				}
				
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

		$viewData = array('labels'=>$labelsArr, 'datasets'=>$sgraphDataset);			
		return view('survey_graph', ['labels'=>$labelsArr, 'datasets'=>$sgraphDataset]);

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

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255'
        ]);
    }

	

}