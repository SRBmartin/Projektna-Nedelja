<?php
    class Main
    {
        public static function set_signup(){
            echo '<form method="post" class="signupForm mx-auto">
                     <div class="form-row">
                         <div class="col-md-6 mb-3">
                             <label for="signupIme">Унесите своје име<span><img src="../img/info.png" class="info-signup" width="18px" data-toggle="tooltip" data-placement="top" title="Име мора бити унето искључиво ћирилицом"></span></label>
                             <input type="text" class="form-control" placeholder="Име" id="signupIme">
                             <div class="text-danger" id="invalid-ime" style="display:none;"><small>Име мора бити написано на ћирилици.</small></div>
                             <div class="text-danger" id="long-ime" style="display:none;"><small>Име мора бити дугачко барем 3, а највише 64 карактера.</small></div>
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="signupPrezime">Унесите своје презиме<span><img src="../img/info.png" class="info-signup" width="18px" data-toggle="tooltip" data-placement="top" title="Презиме мора бити унето искључиво ћирилицом"></span></label>
                             <input type="text" class="form-control" placeholder="Презиме" id="signupPrezime">
                             <div class="text-danger" id="invalid-prezime" style="display:none;"><small>Презиме мора бити написано на ћирилици.</small></div>
                             <div class="text-danger" id="long-prezime" style="display:none;"><small>Презиме мора бити дугачко барем 3, а највише 64 карактера.</small></div>
                         </div>
                     </div>
                     <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="signupKIme">Унесите корисничко име<span><img src="../img/info.png" class="info-signup" width="18px" data-toggle="tooltip" data-placement="top" title="Корисничко име може да садржи ћирилична слова, бројеве или тачку"></span></label>
                            <input type="text" class="form-control" placeholder="Корисничко име" id="signupKIme">
                            <div class="text-danger" id="invalid-kIme" style="display:none;"><small>Корисничко име није у правилном формату.</small></div>
                            <div class="text-danger" id="exists-kIme" style="display:none;"><small>Корисничко име је већ регистровано, одаберите друго.</small></div>
                            <div class="text-danger" id="long-kIme" style="display:none;"><small>Корисничко име мора бити дугачко барем 3, а највише 32 карактера.</small></div>
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="signupEmail">Унесите своју мејл адресу<span><img src="../img/info.png" class="info-signup" width="18px" data-toggle="tooltip" data-placement="top" title="Мејл адреса мора бити на латиничном домену"></span></label>
                             <input type="text" class="form-control" placeholder="email@example.com" id="signupEmail">
                             <div class="text-danger" id="invalid-signup-email" style="display:none;"><small>Мејл адреса није у правилном формату.</small></div>
                             <div class="text-danger" id="uExistErr" style="display:none;"><small>Ова мејл адреса је већ регистрована.</small></div>
                             <div class="text-danger" id="long-email" style="display:none;"><small>Мејл адреса мора бити дугачко барем 3, а највише 128 карактера.</small></div>
                         </div>
                     </div>
                     <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="signupPass">Унесите шифру<span><img src="../img/info.png" class="info-signup" width="18px" data-toggle="tooltip" data-placement="top" title="Шифра мора да садржи латинична слова, бројеве, тачку или зарез"></span></label>
                            <input type="password" autocomplete="new-password" class="form-control" placeholder="Шифра" id="signupPass">
                            <div class="text-danger" id="invalid-signup-password" style="display:none;"><small>Шифра није у исправном формату.</small></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="signupRptPass">Поново унесите шифру<span><img src="../img/info.png" class="info-signup" width="18px" data-toggle="tooltip" data-placement="top" title="Поновљена шифра мора да буде иста као и прва унета."></span></label>
                            <input type="password" autocomplete="new-password" class="form-control" placeholder="Потврдите шифру" id="signupRptPass">
                            <div class="text-danger" id="passMatchErr" style="display:none;"><small>Поновљена шифра није иста.</small></div>
                        </div>
                     </div>
                     <center><div id="signRecap"></div>
                     <div class="text-danger" id="captSignupErr" style="display:none;"><small>Нисте означили безбедносни образац.</small></div>
                     <div class="text-danger" id="emptySignupErr" style="display:none;"><small>Нисте попунили сва поља.</small></div>
                     <div class="text-danger" id="signupErr" style="display:none;"><small>Дошло је до грешке.</small></div>
                     <button type="button" id="signup-submit" class="btn btn-primary">Региструј се</button></center>
                 </form>';
        }

    }