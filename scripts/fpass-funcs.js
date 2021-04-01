$(document).ready(function(){
    function fpassSend(){
        let email = $("#fpassEmail").val();
        if(email == ""){
            if(!$("#fpassEmptyEmail")[0]){
                $("#fpassEmail").addClass("is-invalid");
                $("#fpassEmail").after('<div class="text-danger" id="fpassEmptyEmail"><small>Нисте унели мејл.</small></div>');
            }
        } else{
            $.ajax(
                {
                    url: '../inc/i/fpass.inc.php',
                    method: 'POST',
                    data: {
                        submit: 'fpass',
                        email: email,
                        reCaptchaResponsefPass: grecaptcha.getResponse(signCpt)
                    },
                    beforeSend: function(){
                        $("#fpassEmptyEmail").remove();
                        $(".fpassGErr").hide();
                        $("#fpassEmail").removeClass("is-invalid");
                        $("#fpass-submit").after('<img src="../img/loading-signup.gif" id="loading-fpass-icon" width="64px"/>');
                        $("#loading-fpass-icon").before('<div class="text-primary" id="loadT-fpass">Ово може да потраје и до 30 секунди, будите стрпљиви.</div>');
                        $("#fpass-submit").hide();
                    },
                    success: function(response){
                        $("div.fpass-container").html(response);
                    },
                    error: function(jqXHR){
                        grecaptcha.reset(signCpt);
                        $("#loading-fpass-icon").remove();
                        $("#loadT-fpass").remove();
                        $("#fpass-submit").show();
                        $("#fpassEmail").addClass("is-invalid");
                        switch(jqXHR.status){
                            case 700:
                                $("#captFPassErr").show();
                                break;
                            case 701:
                                $("#invalidEmailFPass").show();
                                break;
                            case 702:
                                $("#uExistsEmailFPass").show();
                                break;
                            case 703:
                                $("#uVerifiedEmailFPass").show();
                                break;
                            default:
                                $("#fPass4VerErr").show();
                                break;
                        }
                    },
                    dataType: 'html'
                }
            );
        }
    }
    let focusFpassFunc = function(e){
        if(e.which == 13){
            fpassSend();
        }
    }
    $("#fpass-submit").on('click',fpassSend);
    $("#fpassEmail").focusin(function(){
        $(this).on('keyup',focusFpassFunc);
    });
    $("#fpassEmail").focusout(function(){
        $(this).off('keyup');
    });
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
});