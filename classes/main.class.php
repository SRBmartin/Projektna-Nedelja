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

        public static function set_mailver(){
            echo '<div class="mailver-container mx-auto">
                    <form method="post" class="mailverForm mx-auto">
                        <center><div style="font-size:18px; font-weight:bold;">Уколико Вам није стигао мејл за верификацију можете поново да га пошаљете.<br>
                        Унесите мејл адресу са којом сте се претходно регистровали:</div></center>
                        <div class="mx-auto" style="width:40%;">
                            <input type="text" class="form-control" id="mailverEmail" placeholder="email@example.com" autocomplete="username">
                            <div class="text-danger mailVerErr" id="invalidEmailVer" style="display:none;"><small>Мејл адреса није у добром формату.</small></div>
                            <div class="text-danger mailVerErr" id="uExistsEmailVer" style="display:none;"><small>Корисник не постоји.</small></div>
                            <div class="text-danger mailVerErr" id="uVerifiedEmailVer" style="display:none;"><small>Овај корисник је већ верификован.</small></div>
                        </div><center>
                        <div id="signRecap" style="margin-top:15px;"></div>
                        <div class="text-danger mailVerErr" id="captMailVerErr" style="display:none;"><small>Нисте означили безбедносни образац.</small></div>
                        <div class="text-danger mailVerErr" id="mail4VerErr" style="display:none;"><small>Дошло је до грешке.</small></div>
                        <button type="button" style="margin-top:15px;" id="mailver-submit" class="btn btn-primary mx-auto">Пошаљи</button></center>
                    </form>
                 </div>';
        }

        public static function set_fpass(){
            echo '<div class="fpass-container mx-auto">
                    <form method="post" class="fpassForm mx-auto">
                        <center><div style="font-size:18px;font-weight:bold;">
                            Уколико сте заборавили шифру можете да је промените.<br> Унесите мејл са којим сте
                            се регистровали на сајт и добићете поруку са упутствима за промену шифре:
                        </div>
                        <div class="mx-auto" style="width:40%;">
                            <input type="text" class="form-control" id="fpassEmail" style="margin-top:15px;" placeholder="email@example.com" autocomplete="username">
                            <div class="text-danger fpassGErr" id="invalidEmailFPass" style="display:none;"><small>Мејл адреса није у добром формату.</small></div>
                            <div class="text-danger fpassGErr" id="uExistsEmailFPass" style="display:none;"><small>Корисник не постоји.</small></div>
                            <div class="text-danger fpassGErr" id="uVerifiedEmailFPass" style="display:none;"><small>Овај корисник није верификован.</small></div>
                            <div id="signRecap" style="margin-top:15px;"></div>
                            <div class="text-danger fpassGErr" id="captFPassErr" style="display:none;"><small>Нисте означили безбедносни образац.</small></div>
                            <div class="text-danger fpassGErr" id="fPass4VerErr" style="display:none;"><small>Дошло је до грешке.</small></div>
                            <button type="button" style="margin-top:15px;" id="fpass-submit" class="btn btn-primary">Пошаљи</button>
                        </div></center>
                    </form>
                 </div>';
        }

        public static function set_citati(){
            $lista_slova = array("А","Б","В","Г","Д","Ђ","Е","Ж","З","И","Ј","К","Л","Љ","М","Н","Њ","О","П","Р","С","Т","Ћ","У","Ф","Х","Ц","Ч","Џ","Ш");
           echo '<div class="citatiCont mx-auto" style="padding-left:1%;padding-right:1%; width:90%;">
                    <div class="row">
                        <div class="col-xl-9">
                            <div id="ListaC">';
                                for($i=0;$i<30;$i++){
                                    echo '<div class="card" style="margin-bottom:5px;">
                                            <div class="card-header" id="heading'.($i+1).'">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.($i+1).'" aria-expanded="true" aria-controls="collapse'.($i+1).'">
                                                    '.$lista_slova[$i].'
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse'.($i+1).'" class="collapse" aria-labelledby="heading'.($i+1).'" data-parent="#ListaC">
                                                <div class="card-body">     
                                                    testest
                                                </div>
                                            </div>
                                        </div>';
                                }
            echo            '</div>
                        </div>
                        <div class="col-xl-3">';
                            if(isset($_SESSION["korisnik"])){
                                echo '<button type="button" class="btn btn-primary btn-lg btn-block">Додајте цитат</button>';
                            } else{
                                echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="addCit" data-toggle="tooltip" data-html="false" data-placement="top" title="Морате бити пријављени да бисте додали цитат.">Додајте цитат</button>';
                            }
                      echo '<div class="w-100 citHR"></div>
                            <div class="searchFormCit text-center w-100">
                                <p class="font-weight-bold" style="font-size:22px;margin-bottom:6px;">Претрага</p>
                                <small style="font-size:14px;text-align:left;">Претражите аутора:</small>
                                <form method="post">
                                    <div class="input-group">
                                        <input class="form-control" id="citSInp" type="search" placeholder="Унесите претрагу">
                                        <span class="input-group-text" id="citSSubmit"><img src="../img/search.png"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="w-100 citHRb"></div>
                        </div>
                    </div>
                </div>';
        }

    }