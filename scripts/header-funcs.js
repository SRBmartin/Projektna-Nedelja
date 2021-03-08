$(document).ready(function(){
    $("#login-submit").on('click',function(){
        let email = $("#LoginEmailNavBar").val();
        let password = $("#LoginPasswordNavBar").val();
        let remember = $("#LoginRememberMeCheck").val();
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
                    url: 'inc/i/login.inc.php',
                    method: 'POST',
                    data: {
                        submit: 'login',
                        email: email,
                        password: password,
                        rememberMe: remember
                    },
                    beforeSend: function(){
                        $("#LoginRememberMeCheck").before('<img src="https://skolskabiblioteka.muharemovic.com/img/loading-login.gif" width="32px" id="loading-login-icon" />');
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
                        $("#loading-login-icon").remove();
                        console.log(response);
                    },
                    dataType: 'html'
                }
            );
        }
    });
});