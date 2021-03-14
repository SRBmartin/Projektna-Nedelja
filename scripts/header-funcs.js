$(document).ready(function(){
        let loginClient = function(){
        let email = $("#LoginEmailNavBar").val();
        let password = $("#LoginPasswordNavBar").val();
        let remember = $("#LoginRememberMeCheck").val();
        let link;
        if($("#napravi-nalog-link").hasClass("active")){
            link = 1;
        } else if($("#zaboravljena-sifra-link").hasClass("active")){
            link = 2;
        } else{
            link = 0;
        }
        if(email == "" || password == ""){
            if(email == ""){
                if(!$("#emailErr")[0]){
                    $("#LoginEmailNavBar").addClass("is-invalid");
                    $("#LoginEmailNavBar").after('<div class="invalid-feedback" id="emailErr">Нисте унели мејл.</div>');
                }
            } else{
                $("#LoginEmailNavBar").removeClass("is-invalid");
                $("#emailErr").remove();
            }
            if(password == ""){
                if(!$("#passwordErr")[0]){
                    $("#LoginPasswordNavBar").addClass("is-invalid");
                    $("#LoginPasswordNavBar").after('<div class="invalid-feedback" id="passwordErr">Нисте унели шифру.</div>');
                }
            } else{
                $("#LoginPasswordNavBar").removeClass("is-invalid");
                $("#passwordErr").remove();
            }
        } else{
            $.ajax(
                {
                    url: 'https://skolskabiblioteka.muharemovic.com/inc/i/login.inc.php',
                    method: 'POST',
                    data: {
                        submit: 'login',
                        email: email,
                        password: password,
                        reCaptchaResponse: grecaptcha.getResponse(),
                        rememberMe: remember,
                        linkIndex: link
                    },
                    beforeSend: function(){
                        $("form#login-form > #login-submit").hide();
                        $("#login-err").hide();
                        $("#capt-err").hide();
                        $("#ver-err").hide();
                        $("#LoginRememberMeCheck").before('<img src="https://skolskabiblioteka.muharemovic.com/img/loading-login.gif" width="64px" id="loading-login-icon" />');
                        if($("#emailErr")[0]){
                            $("#LoginEmailNavBar").removeClass("is-invalid");
                            $("#emailErr").remove();
                        }
                        if($("#passwordErr")[0]){
                            $("#LoginPasswordNavBar").removeClass("is-invalid");
                            $("#passwordErr").remove();
                        }
                    },
                    success: function(response){
                        $("ul#profil-login-ul").html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        $("#loading-login-icon").remove();
                        $("form#login-form > #login-submit").show();
                        $("form#login-fotm > #LoginPasswordNavBar").val('');
                        grecaptcha.reset();
                        switch(jqXHR.status){
                            case 701:
                                if(!$("#passwordErr")[0]){
                                    $("#LoginPasswordNavBar").addClass("is-invalid");
                                    $("#LoginPasswordNavBar").after('<div class="invalid-feedback" id="passwordErr">Шифра није исправна.</div>');
                                }
                                break;
                            case 702:
                                $("#capt-err").show();
                                break;
                            case 703:
                                $("#ver-err").show();
                                break;
                            case 704:
                                if(!$("#emailErr")[0]){
                                    $("#LoginEmailNavBar").addClass("is-invalid");
                                    $("#LoginEmailNavBar").after('<div class="invalid-feedback" id="emailErr">Овај корисник не постоји.</div>');
                                }
                                break;
                            case 705:
                                if(!$("#emailErr")[0]){
                                    $("#LoginEmailNavBar").addClass("is-invalid");
                                    $("#LoginEmailNavBar").after('<div class="invalid-feedback" id="emailErr">Нисте унели мејл.</div>');
                                }
                                break;
                            case 706:
                                if(!$("#passwordErr")[0]){
                                    $("#LoginPasswordNavBar").addClass("is-invalid");
                                    $("#LoginPasswordNavBar").after('<div class="invalid-feedback" id="passwordErr">Нисте унели шифру.</div>');
                                }
                                break;
                            case 707:
                                if(!$("#emailErr")[0]){
                                    $("#LoginEmailNavBar").addClass("is-invalid");
                                    $("#LoginEmailNavBar").after('<div class="invalid-feedback" id="emailErr">Нисте унели мејл.</div>');
                                }
                                if(!$("#passwordErr")[0]){
                                    $("#LoginPasswordNavBar").addClass("is-invalid");
                                    $("#LoginPasswordNavBar").after('<div class="invalid-feedback" id="passwordErr">Нисте унели шифру.</div>');
                                }
                                break;
                            default:
                                $("#login-err").show();
                                break;
                        }
                    },
                    dataType: 'html'
                }
            );
        }
    }
    $("#login-submit").on('click',loginClient);
});