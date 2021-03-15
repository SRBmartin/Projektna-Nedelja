<?php
    include_once "../ss.inc.php";
    if(isset($_POST["submit"]) and $_POST["submit"] === 'req' and isset($_SESSION["korisnik"])){
        echo '<div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-labelledby="logout-modal-h" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="logout-modal-h">Одјави ме</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">Да ли сте сигурни да желите да се одјавите са свог налога?</div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Одустани</button>
                        <button type="button" id="logout-m-button" class="btn btn-primary">Одјави се</button>
                        </div>
                    </div>
                    </div>
                </div>';
    } else{
        header('HTTP/1.0 404 Not found');
    }