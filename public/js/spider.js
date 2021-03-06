function viewportH() {
    var h = $(window).height();
    $('.bg-frame').css('height', h - $('.sub-header').innerHeight());
}

function validateForm() {
    var x = document.forms["myForm"]["email"].value;
    var y = document.forms["myForm"]["password"].value;
    var nameVal = document.forms["myForm"]["name"].value;
    var pwdLength = y.length;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
        $('input[name="email"]').parent().find('.error-message').remove();
        $('input[name="email"]').parent().append('<div class="error-message">Not a valid e-mail address</div>');
        return false;
    } else {
        $('input[name="email"]').parent().find('.error-message').remove();
    }
    if (pwdLength === 0) {
        $('input[name="password"]').parent().find('.error-message').remove();
        $('input[name="password"]').parent().append('<div class="error-message">Please enter your password</div>');
        return false;
    } else {
        $('input[name="password"]').parent().find('.error-message').remove();
    }
    if (nameVal === "") {
        $('input[name="name"]').parent().find('.error-message').remove();
        $('input[name="name"]').parent().append('<div class="error-message">Please enter your name</div>');
        return false;
    } else {
        $('input[name="name"]').parent().find('.error-message').remove();
    }
}
$(function() {
    $('#loginForm input').on('keyup', function() {
        var empty = false,
            isValid = true;
        var x = document.forms["myForm"]["email"].value;
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $('#loginForm input').each(function() {
            if ($(this).val() == '' || reg.test(x) == false) {
                empty = true;
            }
            if ($(this).val() === '') {
                isValid = false;
            }
        });
        if (empty) {
            $('#submitBtn').attr('disabled', 'disabled');
        } else {
            $('#submitBtn').removeAttr('disabled');
        }
        if (isValid) {
            validateForm();
        }
    });
    $('input[name="email"]').on('keypress', function() {
        if ($(this).val() !== "") {
            $(this).addClass('invalid-field');
        } else {
            $(this).removeClass('invalid-field');
        }
    });
    viewportH();

       	var count = 1,
        countLimit = 8;
   	 	if(typeof template_count !== 'undefined')
    	{
    		count = template_count;

    	}

    	if(typeof template_countLimit !== 'undefined')
    	{
    		countLimit = template_countLimit;

    	}

        $addNewSurveyBtn = $('#addNewSurvey'),
        $addNewQuestion = $('#addNewQuestion'),
        $addNewQuestionDiv = $('#addNewQuestionDiv');
    $addNewQuestion.on('click', function() {
        var $this = $(this),
            appendContent = '<div class="form-row new-question"><label class="qnsLabel">New question <span class="qns-count">' + (count + 1) + '</span></label><input type="text" class="textBox" name="question' + (count + 1) + '" /><span class="remove-question"><i class="fa fa-times" aria-hidden="true"></i></span></div>';
        if (count < countLimit) {
            $(appendContent).insertBefore($this.parent());
            $addNewSurveyBtn.attr('disabled', true);
        }
        count++;
        $('.formMainRow').change();
    });
    $('body').on('click', '.remove-question', function() {
        $(this).parents('.form-row').remove();
        count -= 1;
        $('.formMainRow').change();
        $('.qns-count').each(function(index) {
            $(this).html(index + 1);
        });
        $('.new-question').each(function(index) {
            $(this).find('input[type="text"]').attr('name', 'question' + (index + 1));
        });
    });
    $('body').on('change keyup', '.formMainRow', function() {
        var isValid = true;
        $(this).find('input').each(function() {
            if ($(this).val() === '') {
                isValid = false;
            }
        });
        if (isValid) {
            $addNewSurveyBtn.attr('disabled', false);
            if (count < countLimit) {
                $addNewQuestionDiv.show();
            }
        } else {
            $addNewSurveyBtn.attr('disabled', true);
            $addNewQuestionDiv.hide();
        }
    });
    var $popUpContainer = $('#popUpOverlay'),
        $popUp = $('#popUp');
    $('#deleteSelected').on('click', function() {
        $(this).parents('tr').addClass('current-row');
        $popUpContainer.fadeIn();
        $popUp.animate({
            marginTop: '-71px'
        }, 400);
        return false;
    });
    $('#confirmBtn').on('click', function() {
        $popUpContainer.fadeOut();
        $popUp.animate({
            marginTop: '-101px'
        }, 400);
        document.dashboardForm.submit();
        return false;
    });
    $('#cancelBtn').on('click', function() {
        $popUpContainer.fadeOut();
        $popUp.animate({
            marginTop: '-101px'
        }, 400);
        return false;
    });
    $dashTable = $('#dashboardTable');
    $('#checkAll').on('click', function() {
        if ($(this).hasClass('checked-btn') === false) {
            $(this).html('Uncheck all').addClass('checked-btn');
            $dashTable.find('input[type="checkbox"]').prop('checked', true);
        } else {
            $(this).html('Check all').removeClass('checked-btn');
            $dashTable.find('input[type="checkbox"]').prop('checked', false);
        }
        return false;
    });
    $('.table td').each(function(index) {
        $(this).wrapInner('<div />');
        var $th = $(this).parents('.table').find('tr:first-child th').eq($(this).index()).text();
        $(this).attr('data-title', $th);
    });
    if ($('.selectmenu').length > 0) {
        $('.selectmenu').selectmenu();
    }
});
$(window).load(function() {
    viewportH();
    progressBar();
});
$(window).resize(function() {
    viewportH();
});

function updateDataset(target, chart, label) {
    var store = chart.store;
    var exists = false;
    for (var i = 0; i < store.length; i++) {
        if (store[i][0] === label) {
            exists = true;
            chart.datasets.push(store.splice(i, 1)[0][1]);
            target.fadeTo("slow", 1);
        }
    }
    if (!exists) {
        for (var i = 0; i < chart.datasets.length; i++) {
            if (chart.datasets[i].label === label) {
                chart.store.push([label, chart.datasets.splice(i, 1)[0]]);
                target.fadeTo("slow", 0.33);
            }
        }
    }
    chart.update();
}

function selectValidation() {
    var emptyvalues = $('.selectmenu').filter(function() {
        return $(this).val() == ''
    }).length;
    if (emptyvalues == 0) {
        $('.selectmenu').next().removeClass('select-focus');
        document.userSubmitSurveyResponseForm.submit();
    } else {
        $('.selectmenu').each(function() {
            if ($(this).val() === '') {
                $(this).next().addClass('select-focus');
            } else {
                $(this).next().removeClass('select-focus');
            }
        });
    }
    return false;
}

function progressBar() {
    if (typeof percentageValue === 'undefined' || percentageValue === null) {} else {
        $('.progress-bar-div').css({
            width: percentageValue + "%"
        });
        $('.unit-cell span').html(percentageValue);
    }
}


