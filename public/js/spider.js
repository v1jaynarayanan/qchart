function viewportH() {

    var h = $(window).height();

    $('.bg-frame').css('height', h-$('.sub-header').innerHeight());

}

// Login validation

function validateForm() {

    var x = document.forms["myForm"]["email"].value;

    var y = document.forms["myForm"]["password"].value;

    var nameVal = document.forms["myForm"]["name"].value;

    var pwdLength = y.length;

    var atpos = x.indexOf("@");

    var dotpos = x.lastIndexOf(".");

    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {

        $('input[name="email"]').parent().find('.error-message').remove();

        $('input[name="email"]').parent().append('<div class="error-message">Not a valid e-mail address</div>');

        return false;

    } else {

        $('input[name="email"]').parent().find('.error-message').remove();

    }

    if(pwdLength === 0) {

        $('input[name="password"]').parent().find('.error-message').remove();

        $('input[name="password"]').parent().append('<div class="error-message">Please enter your password</div>');

        return false;

    } else {

        $('input[name="password"]').parent().find('.error-message').remove();

    }

    if(nameVal === "") {

        $('input[name="name"]').parent().find('.error-message').remove();

        $('input[name="name"]').parent().append('<div class="error-message">Please enter your name</div>');

        return false;

    } else {

        $('input[name="name"]').parent().find('.error-message').remove();

    }

}

$(function(){

    // Login validation

    $('#loginForm input').on('keyup', function(){

        var empty = false, isValid = true;

        var x = document.forms["myForm"]["email"].value;

        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        $('#loginForm input').each(function() {

            if ($(this).val() == '' || reg.test(x) == false) {

                empty = true;

            }

            if ( $(this).val() === '' ) {

                isValid = false;

            }

        });

        // Enable button all input values is correct

        if (empty) {

            $('#submitBtn').attr('disabled', 'disabled');

        } else {

            $('#submitBtn').removeAttr('disabled');

        }

        // Validate form if all fields value entered

        if(isValid) {

            validateForm();

        }

    });

    // Code for safari label jumbing issue

    $('input[name="email"]').on('keypress', function(){

        if($(this).val() !== "") {

            $(this).addClass('invalid-field');

        } else {

            $(this).removeClass('invalid-field');

        }

    });

    viewportH();

    // Add new survey

    var count = 1, countLimit = 8, $addNewSurveyBtn = $('#addNewSurvey'), $addNewQuestion = $('#addNewQuestion'), $addNewQuestionDiv = $('#addNewQuestionDiv');

    $addNewQuestion.on('click', function(){

        var $this = $(this), appendContent = '<div class="form-row new-question"><label class="qnsLabel">New question <span class="qns-count">'+(count+1)+'</span></label><input type="text" class="textBox" name="question'+(

count+1)+'" /><span class="remove-question"><i class="fa fa-times" aria-hidden="true"></i></span></div>';

        if(count < countLimit) {

            $(appendContent).insertBefore($this.parent());

            $addNewSurveyBtn.attr('disabled', true);

        }

        count++;
        $('.formMainRow').change();
    });

    $('body').on('click', '.remove-question', function(){

        $(this).parents('.form-row').remove();

        count -= 1;

        $('.formMainRow').change();
        $('.qns-count').each(function(index){

            $(this).html(index+1);

        });
        
        
        $('.new-question').each(function(index){
            $(this).find('input[type="text"]').attr('name', 'question'+(index+1));
        }); 
        

    });

    // New survey form validation

    $('body').on('change keyup', '.formMainRow', function(){

        var isValid = true;

        $(this).find('input').each(function(){

            if ( $(this).val() === '' ) {

                isValid = false;

            }

        });

        if(isValid) {

            $addNewSurveyBtn.attr('disabled', false);

            if(count < countLimit) {

                $addNewQuestionDiv.show();

            }

        } else {

            $addNewSurveyBtn.attr('disabled', true);

            $addNewQuestionDiv.hide();

        }

    });

    // Delete row

    var $popUpContainer = $('#popUpOverlay'), $popUp = $('#popUp');

    $('#deleteSelected').on('click', function(){

        $(this).parents('tr').addClass('current-row');

        $popUpContainer.fadeIn();

        $popUp.animate({marginTop:'-71px'}, 400);

        return false;

    });

    $('#confirmBtn').on('click', function(){

        $popUpContainer.fadeOut();

        $popUp.animate({marginTop:'-101px'}, 400);

        document.dashboardForm.submit();

        return false;

    });

    $('#cancelBtn').on('click', function(){

        $popUpContainer.fadeOut();

        $popUp.animate({marginTop:'-101px'}, 400);

        return false;

    });

    // Toggle check

    $dashTable = $('#dashboardTable');

    $('#checkAll').on('click', function(){

        if($(this).hasClass('checked-btn') === false) {

            $(this).html('Uncheck all').addClass('checked-btn');

            $dashTable.find('input[type="checkbox"]').prop('checked', true);

        } else {

            $(this).html('Check all').removeClass('checked-btn');

            $dashTable.find('input[type="checkbox"]').prop('checked', false);

        }

        return false;

    });



});

$(window).load(function(){

    viewportH();

});

$(window).resize(function(){

    viewportH();

});