<?php
    class Main
    {
        public static function set_signup(){
            echo '<form method="post" class="signupForm mx-auto">
                     <div class="form-row">
                         <div class="col-md-6 mb-3">
                             <label for="signupIme">Унесите своје име</label>
                             <input type="text" class="form-control" placeholder="Име" id="signupIme">
                         </div>
                         <div class="col-md-6 mb-3">
                             <label for="signupPrezime">Унесите своје презиме</label>
                             <input type="text" class="form-control" placeholder="Презиме" id="signupPrezime">
                         </div>
                     </div>
                     <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="signupKIme">Унесите корисничко име</label>
                            <input type="text" class="form-control" placeholder="Корисничко име" id="signupKIme">
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="signupEmail">Унесите своју адресу електронске поште (мејл)</label>
                             <input type="text" class="form-control" placeholder="email@example.com" id="signupEmail">
                         </div>
                     </div>
                     <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="signupPass">Унесите шифру</label>
                            <input type="password" autocomplete="new-password" class="form-control" placeholder="Шифра" id="signupPass">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="signupRptPass">Поново унесите шифру</label>
                            <input type="password" autocomplete="new-password" class="form-control" placeholder="Потврдите шифру" id="signupRptPass">
                        </div>
                     </div>
                     <center><div id="signRecap"></div>
                     <div class="text-danger" id="captSignupErr" style="display:none;"><small>Нисте означили безбедносни образац.</small></div>
                     <button type="button" id="signup-submit" class="btn btn-primary">Региструј се</button></center>
                 </form>';
        }

    }