function viewportH() {
    var h = $(window).height();
    $('.bg-frame').css('height', h-$('.sub-header').innerHeight());
}
$(function(){
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