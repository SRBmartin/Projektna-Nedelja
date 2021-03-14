<?php
    class Header
    {
        public static function get_title()
        {
            $sql = "SELECT title FROM inf;";
            $rezultat = Dbh::connect()->query($sql);
            $inf = $rezultat->fetch_assoc();
            return $inf["title"];
        }

        public static function set_header_carousel_cookie()
        {
            $sql = "SELECT header_carousel_number FROM inf;";
            $rezultat = Dbh::connect()->query($sql);
            $inf = $rezultat->fetch_assoc();
            $cnum = (int)$inf["header_carousel_number"];
            if(!isset($_COOKIE["cnum"])){
                setcookie("cnum",$cnum,time()+86400*10,"/");
            } else{
                setcookie("cnum","",time()-3600);
                setcookie("cnum",$cnum,time()+86400*10,"/");
            }
        }

        public static function set_header_carousel()
        {
            $sql = "SELECT header_carousel_number FROM inf;";
            $rezultat = Dbh::connect()->query($sql);
            $inf = $rezultat->fetch_assoc();
            $broj = (int)$inf["header_carousel_number"];
            if($broj !== 0){ //ako postoji neka slika za carousel da se postavi
                echo '<div class="header-carousel">';
                if($broj === 1){
                    echo '<img class="d-block header-carousel-img img-fluid" id="hcId0" src="https://skolskabiblioteka.muharemovic.com/img/hcId0.png">';
                } else {
                    echo '<div id="carouselHeaderImg" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                          <li data-target="#carouselHeaderImg" data-slide-to="0"></li>';
                          for($i = 1; $i < $broj; $i++){
                              echo '<li data-target="#carouselHeaderImg" data-slide-to="'.$i.'"></li>';
                            }
                            echo '</ol>
                         <div class="carousel-inner">
                         <div class="carousel-item active">
                            <img class="d-block header-carousel-img img-fluid" id="hcId0" src="https://skolskabiblioteka.muharemovic.com/img/hcId0.png">
                         </div>';
                    for($i = 1; $i < $broj; $i++){
                        echo '<div class="carousel-item">
                             <img class="d-block header-carousel-img img-fluid" id="hcId'.$i.'" src="https://skolskabiblioteka.muharemovic.com/img/hcId'.$i.'.png">
                             </div>';
                    }
                    echo '</div>
                         <a class="carousel-control-prev" href="#carouselHeaderImg" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         </a>
                         <a class="carousel-control-next" href="#carouselHeaderImg" role="button" data-slide="next">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                         </a>';
                }
                echo '</div>
                     </div>';
            }
        }

        public static function set_navbar()
        {
            $title = self::get_title();
            echo '<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
                 <a class="navbar-brand navbar-L-text" href="https://skolskabiblioteka.muharemovic.com">
                    <img src="https://skolskabiblioteka.muharemovic.com/img/logo.png" class="navbar-brand-img img-fluid " />
                    Школска библиотека
                 </a>
                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Header-Navbar-Dropdown-Knjizevnost" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="Header-Navbar-Dropdown-Knjizevnost">
                    <ul class="navbar-nav">';
                        if(isset($_SESSION["page_index_navbar_active"])  and $_SESSION["page_index_navbar_active"] === 0){
                            echo '<li class="nav-item active">'; 
                            unset($_SESSION["page_index_navbar_active"]);
                        } else{
                            echo '<li class="nav-item">'; 
                        }
                        echo '<a class="nav-link" href="https://skolskabiblioteka.muharemovic.com">Почетна</a>
                             </li>';
                        if(isset($_SESSION["page_index_navbar_active"])  and ($_SESSION["page_index_navbar_active"] >= 1 and $_SESSION["page_index_navbar_active"] <= 3)){
                            echo '<li class="nav-item dropdown active">'; 
                        } else{
                            echo '<li class="nav-item dropdown">'; 
                        }
                        echo '<a class="nav-link dropdown-toggle" id="Knjizevnost-Navbar-Dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Књижевност</a>
                             <div class="dropdown-menu" aria-labelledby="Knjizevnost-Navbar-Dropdown">';
                             if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 1){
                                echo '<a class="dropdown-item active" href="https://skolskabiblioteka.muharemovic.com/p/k/epika">Епика</a>';
                                unset($_SESSION["page_index_navbar_active"]);
                             } else{
                                echo '<a class="dropdown-item" href="https://skolskabiblioteka.muharemovic.com/p/k/epika">Епика</a>';
                             }
                             if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 2){
                                echo '<a class="dropdown-item active" href="https://skolskabiblioteka.muharemovic.com/p/k/lirika">Лирика</a>';
                                unset($_SESSION["page_index_navbar_active"]);
                             } else{
                                echo '<a class="dropdown-item" href="https://skolskabiblioteka.muharemovic.com/p/k/lirika">Лирика</a>';
                             }
                             if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 3){
                                echo '<a class="dropdown-item active" href="https://skolskabiblioteka.muharemovic.com/p/k/drama">Драма</a>';
                                unset($_SESSION["page_index_navbar_active"]);
                             } else{
                                echo '<a class="dropdown-item" href="https://skolskabiblioteka.muharemovic.com/p/k/drama">Драма</a>';
                             }
                        echo '</div></li>';
                          if(isset($_SESSION["page_index_navbar_active"])  and $_SESSION["page_index_navbar_active"] === 4){
                            echo '<li class="nav-item active">'; 
                            unset($_SESSION["page_index_navbar_active"]);
                        } else{
                            echo '<li class="nav-item">'; 
                        }
                        echo '<a class="nav-link" href="https://skolskabiblioteka.muharemovic.com/p/o_nama">О нама</a>
                        </li>';
                echo '</ul>
                     <ul class="navbar-nav ml-auto" id="profil-login-ul">';
                        if(isset($_SESSION["korisnik"]["admin"]) and $_SESSION["korisnik"]["admin"] === "y"){
                            if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 5){
                                echo '<li class="nav-item active">';
                            } else{
                                echo '<li class="nav-item">';
                            }
                            echo '<a class="nav-link" href="https://skolskabiblioteka.muharemovic.com/p/urpan">Уреднички панел</a>
                                 </li>';
                        }
                        if(!isset($_SESSION["korisnik"])){
                            if(isset($_SESSION["page_index_navbar_active"]) and ($_SESSION["page_index_navbar_active"] === 6 or $_SESSION["page_index_navbar_active"] === 7)){
                                echo '<li class="nav-item dropdown active" id="Login-Li">';
                            } else{
                                echo '<li class="nav-item dropdown" id="Login-Li">';
                            }
                            echo '<a class="nav-link dropdown-toggle" id="NavBarDropDownKorisnik" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Пријави се</a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="NavBarDropDownKorisnik">
                                <form class="px-4 py-3" id="login-form">
                                    <div class="form-group">
                                        <label for="LoginEmailNavBar">Мејл адреса</label>
                                        <input type="email" class="form-control" id="LoginEmailNavBar" placeholder="email@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="LoginPasswordNavBar">Шифра</label>
                                        <input type="password" class="form-control" id="LoginPasswordNavBar" placeholder="********">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="LoginRememberMeCheck" value="RememberMe">
                                        <label class="form-check-label" for="LoginRememberMeCheck">Запамти ме</label>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6LfpjHgaAAAAAOMR8ghLBFYjRQYn9iNJIdNlavnP"></div>
                                    <div class="invalid-feedback" id="capt-err" style="display:none;">Нисте означили заштитни слој reCaptcha.</div>
                                    <div class="invalid-feedback" id="login-err" style="display:none;">Дошло је до грешке. Покушајте касније.</div>
                                    <div class="invalid-feedback" id="ver-err" style="display:none;">Ваш налог није верификован Проверите свој мејл и потражите линк за верификацију, ако желите можете опет да пошаљете мејл притисните <a href="https://skolskabiblioteka.muharemovic.com/p/mailver">овде</a>.</div>
                                    <button type="button" id="login-submit" class="btn btn-primary">Пријави се</button>
                                </form>
                                <div class="dropdown-divider"></div>';
                                if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 6){
                                    echo '<a class="dropdown-item active" id="napravi-nalog-link" href="https://skolskabiblioteka.muharemovic.com/p/signup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Направите налог</a>';
                                } else{
                                    echo '<a class="dropdown-item" id="napravi-nalog-link" href="https://skolskabiblioteka.muharemovic.com/p/signup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Направите налог</a>';
                                }
                                if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 7){
                                    echo '<a class="dropdown-item active" id="zaboravljena-sifra-link" href="https://skolskabiblioteka.muharemovic.com/p/fpass">&nbsp;&nbsp;Заборављена шифра&nbsp;&nbsp;</a>';
                                } else{
                                    echo '<a class="dropdown-item" id="zaboravljena-sifra-link" href="https://skolskabiblioteka.muharemovic.com/p/fpass">&nbsp;&nbsp;Заборављена шифра&nbsp;&nbsp;</a>';
                                }
                                echo '</div>
                                      </li>';
                        } else{
                            if(isset($_SESSION["korisnik"]["admin"]) and $_SESSION["korisnik"]["admin"] > 0){
                                echo '<li class="nav-item">
                                    <a class="nav-link" href="https://skolskabiblioteka.muharemovic.com/p/urpan">Уреднички панел</a>
                                    </li>';
                            }
                            echo '<li class="nav-item dropdown" id="User-CP-Navbar">
                                    <a class="nav-link dropdown-toggle" id="NavBarDropDownKorisnik" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'. $_SESSION["korisnik"]["korisnicko_ime"] .'</a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="NavBarDropDownKorisnik">
                                    <a class="dropdown-item" href="#">Профил</a>
                                    <a class="dropdown-item" href="#">Моје књиге</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="https://skolskabiblioteka.muharemovic.com/p/logout">Одјави се</a>
                                    </div>
                                </li>';
                        } //NE ZABORAVI DA DODAS INDEXE
                echo '</ul>
                 </div>
                 </nav>';
        }
        
    }