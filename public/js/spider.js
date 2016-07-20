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
        var empty = false;
        var x = document.forms["myForm"]["email"].value;
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $('#loginForm input').each(function() {
            if ($(this).val() == '' || reg.test(x) == false) {
                empty = true;
            }
        });
        if (empty) {
            $('#submitBtn').attr('disabled', 'disabled');
        } else {
            $('#submitBtn').removeAttr('disabled');
        }
        validateForm();
    });
    $('input[name="email"]').on('keypress', function(){
        if($(this).val() !== "") {
            $(this).addClass('invalid-field');
        } else {
            $(this).removeClass('invalid-field');
        }
    });
    viewportH();
});
$(window).load(function(){
    viewportH();
});
$(window).resize(function(){
    viewportH();
});

function CheckAll()
{
   var arrCheckBoxes = document.dashboardForm.getElementsByClassName("checkbox-btn");
   for (var i = 0; i < arrCheckBoxes.length; i++) {
      arrCheckBoxes[i].checked = true;
   }
}

function UnCheckAll(chk)
{
    for (i = 0; i < chk.length; i++)
        chk[i].checked = false ;
}
