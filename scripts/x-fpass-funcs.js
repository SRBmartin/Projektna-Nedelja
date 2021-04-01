jQuery.fn.extend({authprm:function(t,e=!0){t=decodeURIComponent(t);var n=new Array,r=null;if("#document"==$(this).attr("nodeName"))window.location.search.search(t)>-1&&(r=window.location.search.substr(1,window.location.search.length).split("&"));else if(void 0!==$(this).attr("src")){if((i=$(this).attr("src")).indexOf("?")>-1)r=i.substr(i.indexOf("?")+1).split("&")}else{if(void 0===$(this).attr("href"))return null;var i;(i=$(this).attr("href")).indexOf("?")>-1&&(r=i.substr(i.indexOf("?")+1).split("&"))}if(null==r)return null;for(var l=0;l<r.length;l++){var o=r[l].split("=");decodeURIComponent(o[0])==t&&n.push(void 0===o[1]?null:decodeURIComponent(o[1]))}return 0==n.length?null:1==n.length?n[0]:e?n[n.length-1]:n}});
$(document).ready(function(){
    function xFpassSend(){
        let pass = $("#fpassPass").val();
        let passRpt = $("#fpassPassRpt").val();
        if(pass == "" || passRpt == ""){
            if(pass == ""){
                if(!$(".arf1")[0]){
                    $("#fpassPass").addClass("is-invalid");
                    $("#fpassPass").after('<div class="text-danger arf1 aftErr"><small>Нисте унели нову шифру.</small></div>')
                }
            }
            if(passRpt == ""){
                if(!$(".arf2")[0]){
                    $("#fpassPassRpt").addClass("is-invalid");
                    $("#fpassPassRpt").after('<div class="text-danger arf2 aftErr"><small>Нисте поновили нову шифру.</small></div>')
                }
            }
        } else{
            $.ajax(
                {
                    url: '../inc/i/x.fpass.inc.php',
                    method: 'POST',
                    data: {
                        submit: 'x-fpass',
                        passfp: pass,
                        passRptfp: passRpt,
                        reCaptchaResponsexFpass: grecaptcha.getResponse(signCpt),
                        fk: $(document).authprm("fkey"),
                        au: $(document).authprm("auth")
                    },
                    beforeSend: function(){
                        $(".aftErr").remove();
                        $("#x-fpass-submit").hide();
                        $("#x-fpass-submit").after('<img src="../img/loading-signup.gif" width="64px" id="loading-xFpass-icon" />');
                        $("#loading-xFpass-icon").before('<div class="text-primary" id="loadT-xFpass">Ово може да потраје и до 30 секунди, будите стрпљиви.</div>');
                        $(".xFpassGErr").hide();
                        $("#fpassPass").removeClass("is-invalid");
                        $("#fpassPassRpt").removeClass("is-invalid");
                    },
                    success: function(response){
                        $(".fpass-container").html(response);
                    },
                    error: function(jqXHR){
                        grecaptcha.reset(signCpt);
                        $("#loading-xFpass-icon").remove();
                        $("#loadT-xFpass").remove();
                        $("#x-fpass-submit").show();
                        $("#fpassPass").val('');
                        $("#fpassPassRpt").val('');
                        switch(jqXHR.status){
                            case 700:
                                $("#captxFPassErr").show();
                                break;
                            case 701:
                                $("#fpassPass").addClass("is-invalid");
                                $("#invxFpass").show();
                                break;
                            case 702:
                                $("#fpassPass").addClass("is-invalid");
                                $("#fpassPassRpt").addClass("is-invalid");
                                $("#ntmtchxFpass").show();
                                break;
                            default:
                                $("#XfPass4VerErr").show();
                                break;
                        }
                    },
                    dataType: 'html'
                }
            );
        }
    }
    $("#x-fpass-submit").on('click',xFpassSend);
});