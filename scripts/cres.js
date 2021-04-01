$(document).ready(function(){
    $(window).resize(function(){
        if($(window).width() <= 767.98){
            $(".citatiCont").css({'width':'100%',
                                  'padding-left':'0',
                                  'padding-right':'0'
                                });

        } else{
            $(".citatiCont").css({'width':'90%',
                                  'padding-left':'1%',
                                  'padding-right':'1%'
                                });
        }
    });
    if($(window).width() <= 767.98){
        $(".citatiCont").css({'width':'100%',
                              'padding-left':'0',
                              'padding-right':'0'  
                            });
    }
    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
});
function rmvTltp() {
    $("#addCit").tooltip('dispose');
}