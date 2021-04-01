$(document).ready(function(){
    if($(window).width() <= 575.98){
        $(".navbar-L-text").css('font-size','25px');
        $("#logo-navbar").css({'width':'26px','height':'26px'});
        $(".header").css('width','100%');
    }
    $(window).resize(function(){
        if($(window).width() <= 575.98){
            $(".navbar-L-text").css('font-size','25px');
            $("#logo-navbar").css({'width':'26px','height':'26px'});
            $(".header").css('width','100%');
        } else if($(window).width() > 575.98){
            $(".navbar-L-text").css('font-size','30px');
            $("#logo-navbar").css({'width':'32px','height':'32px'});
            $(".header").css('width','90%');
        }
    });
    $("button#logout-m-button").on('click',function(){
        window.location.href = 'https://skolskabiblioteka.muharemovic.com/p/logout';
    });
});