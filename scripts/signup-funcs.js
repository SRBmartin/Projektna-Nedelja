$(document).ready(function(){
    if($(window).width() <= 575.98){
        $(".signupForm").css('width','90%');
        $(".sUContainer").css('width','100%');
    }
    $(window).resize(function(){
        if($(window).width() > 575.98){
            $(".signupForm").css('width','70%');
            $(".sUContainer").css('width','90%');
        } else{
            $(".signupForm").css('width','90%');
            $(".sUContainer").css('width','100%');
        }
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    function signupUser(){
        let ime = $("#signupIme").val();
        let prezime = $("#signupPrezime").val();
        let kIme = $("#signupKIme").val();
        let email = $("#signupEmail").val();
        let pass = $("#signupPass").val();
        let passRpt = $("#signupRptPass").val();
        
        if(ime == "" || prezime == "" || kIme == "" || email == "" || pass == "" || passRpt == ""){
            if(ime == ""){
                if(!$("#nameErr")[0]){
                    $("#signupIme").addClass("is-invalid");
                    $("#signupIme").after('<div class="text-danger" id="nameErr"><small>Нисте унели име.</small></div>');
                }
            } else{
                $("#signupIme").removeClass("is-invalid");
                $("#nameErr").remove();
            }
            if(prezime == ""){
                if(!$("#surnameErr")[0]){
                    $("#signupPrezime").addClass("is-invalid");
                    $("#signupPrezime").after('<div class="text-danger" id="surnameErr"><small>Нисте унели презиме.</small></div>');
                }
            } else{
                $("#signupPrezime").removeClass("is-invalid");
                $("#surnameErr").remove();
            }
            if(kIme == ""){
                if(!$("#uNameErr")[0]){
                    $("#signupKIme").addClass("is-invalid");
                    $("#signupKIme").after('<div class="text-danger" id="uNameErr"><small>Нисте унели корисничко име.</small></div>');
                }
            } else{
                $("#signupKIme").removeClass("is-invalid");
                $("#uNameErr").remove();
            }
            if(email == ""){
                if(!$("#signupEmailErr")[0]){
                    $("#signupEmail").addClass("is-invalid");
                    $("#signupEmail").after('<div class="text-danger" id="signupEmailErr"><small>Нисте унели мејл адресу.</small></div>');
                }
            } else{
                $("#signupEmail").removeClass("is-invalid");
                $("#signupEmailErr").remove();
            }
            if(pass == ""){
                if(!$("#passErr")[0]){
                    $("#signupPass").addClass("is-invalid");
                    $("#signupPass").after('<div class="text-danger" id="passErr"><small>Нисте унели шифру.</small></div>');
                }
            } else{
                $("#signupPass").removeClass("is-invalid");
                $("#passErr").remove();
            }
            if(passRpt == ""){
                if(!$("#passRptErr")[0]){
                    $("#signupRptPass").addClass("is-invalid");
                    $("#signupRptPass").after('<div class="text-danger" id="passRptErr"><small>Нисте поновили шифру.</small></div>');
                }
            } else{
                $("#signupRptPass").removeClass("is-invalid");
                $("#passRptErr").remove();
            }
        } else{
            $.ajax(
                {
                    url: 'https://skolskabiblioteka.muharemovic.com/inc/i/signup.inc.php',
                    method: 'POST',
                    data: {
                        submit: 'signup',
                        ime: ime,
                        prezime: prezime,
                        kIme: kIme,
                        email: email,
                        password: pass,
                        passwordRpt: passRpt,
                        reCaptchaResponseSignUp: grecaptcha.getResponse(signCpt)
                    },
                    beforeSend: function(){
                        $("#signup-submit").hide(); 
                        $("#signup-submit").after('<img src="../img/loading-signup.gif" id="loading-signup-icon" width="64px"/>');
                        $("#loading-signup-icon").before('<div class="text-primary" id="loadT-singup">Ово може да потраје и до 30 секунди, будите стрпљиви.</div>');
                        $("#captSignupErr").hide();
                        $("#emptySignupErr").hide();
                        $("#invalid-ime").hide();
                        $("#invalid-prezime").hide();
                        $("#signupErr").hide();
                        $("#invalid-kIme").hide();
                        $("#invalid-signup-email").hide();
                        $("#invalid-signup-password").hide();
                        $("#passMatchErr").hide();
                        $("#uExistErr").hide();
                        $("#exists-kIme").hide();
                        $("#long-ime").hide();
                        $("#long-prezime").hide();
                        $("#long-kIme").hide();
                        $("#long-email").hide();
                        $("#signupIme").removeClass("is-invalid");
                        $("#signupPrezime").removeClass("is-invalid");
                        $("#signupKIme").removeClass("is-invalid");
                        $("#signupEmail").removeClass("is-invalid");
                        $("#signupPass").removeClass("is-invalid");
                        $("#signupRptPass").removeClass("is-invalid");
                        $("#nameErr").remove();
                        $("#surnameErr").remove();
                        $("#uNameErr").remove();
                        $("#signupEmailErr").remove();
                        $("#passErr").remove();
                        $("#passRptErr").remove();
                    },
                    success: function(response){
                        $("div.sUContainer").html(response);
                    },
                    error: function(jqXHR){
                        $("#signup-submit").show();
                        $("#loading-signup-icon").remove();
                        $("#loadT-singup").remove();
                        $("#signupPass").val('');
                        $("#signupRptPass").val('');
                        grecaptcha.reset(signCpt);
                        switch(jqXHR.status){
                            case 700:
                                $("#captSignupErr").show();
                                break;
                            case 701:
                                $("#emptySignupErr").show();
                                break;
                            case 702:
                                $("#invalid-ime").show();
                                $("#invalid-prezime").show();
                                $("#signupIme").addClass("is-invalid");
                                $("#signupPrezime").addClass("is-invalid");                     
                                break;
                            case 703:
                                $("#invalid-ime").show();
                                $("#signupIme").addClass("is-invalid");
                                break;
                            case 704:
                                $("#invalid-prezime").show();
                                $("#signupPrezime").addClass("is-invalid");
                                break;
                            case 705:
                                $("#invalid-kIme").show();
                                $("#signupKIme").addClass("is-invalid");
                                break;
                            case 706:
                                $("#invalid-signup-email").show();
                                $("#signupEmail").addClass("is-invalid");
                                break;
                            case 707:
                                $("#invalid-signup-password").show();
                                $("#signupPass").addClass("is-invalid");
                                break;
                            case 708:
                                $("#passMatchErr").show();
                                $("#signupRptPass").addClass("is-invalid");
                                break;
                            case 709:
                                $("#uExistErr").show();
                                $("#signupEmail").addClass("is-invalid");
                                $("#signupEmail").val('');
                                break;
                            case 710:
                                $("#exists-kIme").show();
                                $("#signupKIme").addClass("is-invalid");
                                $("#signupKIme").val('');
                                break;
                            case 711:
                                $("#long-ime").show();
                                $("#signupIme").addClass("is-invalid");
                                $("#signupIme").val('');
                                break;
                            case 712:
                                $("#long-prezime").show();
                                $("#signupPrezime").addClass("is-invalid");
                                $("#signupPrezime").val('');
                                break;
                            case 713:
                                $("#long-kIme").show();
                                $("#signupKIme").addClass("is-invalid");
                                $("#signupKIme").val('');
                                break;
                            case 714:
                                $("#long-email").show();
                                $("#signupEmail").addClass("is-invalid");
                                $("#signupEmail").val('');
                                break;
                            default:
                                $("#signupErr").show();
                                break;
                        }
                    },
                    dataType: 'html'
                }
            );
        }
    }
    $("#signup-submit").on('click',signupUser);
});