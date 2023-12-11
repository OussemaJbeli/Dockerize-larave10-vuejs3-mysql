$(document).ready(function(){

    $("#toggler").click(function(event){
        $('#wrap').toggleClass('toggled');

        var right = $('.sidebar').css("right");
        if (right == '0px')
        {
            $('.sidebar').css({ 'right': '-17rem' });
            $('.layer').fadeOut();
        }
        else {
            $('.sidebar').css({ 'right': '0' });
            $('.layer').fadeIn(); 
        }
    });

    $('.layer').click(function () {
        $('.sidebar').css({ 'right': '-17rem' });
        $('.layer').fadeOut();
    });

    $(".search-icon").click(function () {
        $(".search-input").slideToggle("slow");
    });
});