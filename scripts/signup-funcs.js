$(document).ready(function(){
    if($(window).width() <= 575.98){
        $("form.signupForm").css('width','90%');
    }
    $(window).resize(function(){
        if($(window).width() > 575.98){
            $("form.signupForm").css('width','70%');
        } else{
            $("form.signupForm").css('width','90%');
        }
    });
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
                if(!$("#emailErr")[0]){
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
                    },
                    success: function(){
                         

                    },
                    error: function(jqXHR){
                        $("#signup-submit").show();
                        $("#loading-signup-icon").remove();
                        grecaptcha.reset(signCpt);
                        switch(jqXHR.status){
                            case 700:
                                $("#captSignupErr").show();
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