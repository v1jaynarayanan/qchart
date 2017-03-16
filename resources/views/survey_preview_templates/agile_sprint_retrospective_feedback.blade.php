@extends('layouts.levelthree')


@section('content')

        <div class="container sub-page">
     
     @include('survey_preview_templates.page_header',array('name' => 'Agile Sprint Retrospective'))


            <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Survey Question</th>
                        <th>Answer <h5>Enter a value between 1 (low / bad) and 10 (high / good)</h5></th>
                    </tr>
                                             

                            <tr>
                                <td>1</td>
                                <td><label class="required-label"><label class="qnsLabel"> Do you think the team delivered all stories as per Sprint commitment? </label><input type="hidden" name="question1" value="1"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer1"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>2</td>
                                <td><label class="required-label"><label class="qnsLabel"> Was high business value delivered to the customer at the end of the Sprint? </label><input type="hidden" name="question2" value="2"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer2"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>3</td>
                                <td><label class="required-label"><label class="qnsLabel"> Did the team communicate well during the Sprint? </label><input type="hidden" name="question3" value="3"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer3"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>4</td>
                                <td><label class="required-label"><label class="qnsLabel"> Did the team adhere to Scrum rules and practices? </label><input type="hidden" name="question4" value="4"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer4"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>5</td>
                                <td><label class="required-label"><label class="qnsLabel"> Did the team understand Sprint scope and goal? </label><input type="hidden" name="question5" value="5"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer5"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>6</td>
                                <td><label class="required-label"><label class="qnsLabel"> Was the team enthusiastic throughout the Sprint? </label><input type="hidden" name="question6" value="6"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer6"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>7</td>
                                <td><label class="required-label"><label class="qnsLabel"> Did the team achieve the optimum velocity? </label><input type="hidden" name="question7" value="7"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer7"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                         

                            <tr>
                                <td>8</td>
                                <td><label class="required-label"><label class="qnsLabel"> What would your overall score be for the Sprint? </label><input type="hidden" name="question8" value="8"></label></td>
                                <td><div class="form-row new-question">
                                        <select class="selectmenu" name="answer[]" id="answer8"> 
                                                 <option value="" selected="selected"></option>
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                        </select>         
                                    </div>
                                </td>
                            </tr>   
                       

                                 
                                 </table>


 

             <div class="group clearfix">
                <a class="btn fR" disabled >Submit Response</a>
             </div>
             </div>



 


@include('survey_preview_templates.css',array('link' => 'agile-sprint-retrospective-feedback'))

@endsection
