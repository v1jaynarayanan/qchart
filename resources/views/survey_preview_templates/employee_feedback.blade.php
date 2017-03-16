@extends('layouts.levelthree')


@section('content')

        <div class="container sub-page">
     
     @include('survey_preview_templates.page_header',array('name' => 'EMPLOYEES'))


 <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Survey Question</th>
                        <th>Answer <h5>Enter a value between 1 (low / bad) and 10 (high / good)</h5></th>
                    </tr>
                                             

                            <tr>
                                <td>1</td>
                                <td><label class="required-label"><label class="qnsLabel"> Do you think the team produced value to business? </label><input type="hidden" name="question1" value="24"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> Did the team welcome changes to requirements? </label><input type="hidden" name="question2" value="25"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> How well do you think the team colloborated? </label><input type="hidden" name="question3" value="26"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> Did the team members trust each other? </label><input type="hidden" name="question4" value="27"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> Was there enough face to face communication with in the team? </label><input type="hidden" name="question5" value="28"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> Does the team focus on achieving technical excellence? </label><input type="hidden" name="question6" value="29"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> Did the team reflect on its performance? </label><input type="hidden" name="question7" value="30"></label></td>
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
                                <td><label class="required-label"><label class="qnsLabel"> Do you think the team is self organised? </label><input type="hidden" name="question8" value="31"></label></td>
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



 


@include('survey_preview_templates.css',array('link' => 'employee-feedback'))

@endsection
