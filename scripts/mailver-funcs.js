$(document).ready(function(){
    function mailverSend(){
        let email = $("#mailverEmail").val();
        if(email == ""){
            if(!$("#emailVerErr")[0]){
                $("#mailverEmail").addClass("is-invalid");
                $("#mailverEmail").after('<div class="text-danger" id="emailVerErr"><small>Нисте унели мејл.</small></div>');
            }
        } else{
            $.ajax(
                {
                    url: '../inc/i/mailver.inc.php',
                    method: 'POST',
                    data: {
                        submit: 'mailver',
                        email: email,
                        reCaptchaResponseMailVer: grecaptcha.getResponse(signCpt)
                    },
                    beforeSend: function(){
                        $(".mailVerErr").hide();
                        $("#mailverEmail").removeClass("is-invalid");
                        $("#mailver-submit").hide();
                        $("#mailver-submit").after('<img src="../img/loading-signup.gif" id="loading-mailver-icon" width="64px"/>');
                        $("#loading-mailver-icon").before('<div class="text-primary" id="loadT-mailver">Ово може да потраје и до 30 секунди, будите стрпљиви.</div>');
                    },
                    success: function(response){
                        $("div.mailver-container").html(response);
                    },
                    error: function(jqXHR){
                        $("#mailver-submit").show();
                        $("#loading-mailver-icon").remove();
                        $("#mailverEmail").val('');
                        $("#loadT-mailver").remove();
                        $("#emailVerErr").remove();
                        $("#mailverEmail").removeClass("is-invalid");
                        grecaptcha.reset(signCpt);
                        switch(jqXHR.status){
                            case 700:
                                $("#captMailVerErr").show();
                                $("#mailverEmail").addClass("is-invalid");
                                break;
                            case 701:
                                $("#invalidEmailVer").show();
                                $("#mailverEmail").addClass("is-invalid");
                                break;
                            case 702:
                                $("#uExistsEmailVer").show();
                                $("#mailverEmail").addClass("is-invalid");
                                break;
                            case 703:
                                $("#uVerifiedEmailVer").show();
                                $("#mailverEmail").addClass("is-invalid");
                                break;
                            default: 
                                $("#mailVer4Err").show();
                                break;
                        }
                    },
                    dataType: 'html'
                }
            );
        }
    }
    let focusMailverFunc = function(e){
        if(e.which == 13){
            mailverSend();
        }
    }
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    $("#mailver-submit").on('click',mailverSend);
    $("#mailverEmail").focusin(function(){
        $(this).on('keyup',focusMailverFunc);
    });
    $("#mailverEmail").focusout(function(){
        $(this).off('keyup');
    });
});