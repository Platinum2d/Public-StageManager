<?php
include '../../functions.php';
checkLogin ( ceoType , "../../../" );
checkEmail();
open_html ( "Contatta" );
import("../../../");

?>
<script src='js/scripts.js?0.1'></script>
<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Contatta</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-10">
                            <form id="contactForm" onsubmit="sendMail (); return false;">
                                <div class="form-group row">
                                	<div class="col col-sm-6">
                                        <label for="receiverType" class="select">Seleziona il tipo di utente che vuoi contattare:</label>
                                        <br>
                                        <select class="form-control titolo-non-selezionabile" id="receiverType">
                                            <option value="-1" selected>Seleziona un'opzione</option>
                                            <option value="<?php echo docrefType;?>">Docente referente</option>
                                            <option value="<?php echo doctutType;?>">Docente tutor</option>
                                            <option value="<?php echo studType;?>">Studente</option>
                                            <option value="<?php echo aztutType;?>">Tutor</option>
                                        </select>
                                    </div>
                                	<div class="col col-sm-6">
                                        <label for="receiver" class="select">Seleziona il destinatario della email:</label>
                                        <br>
                                        <select class="form-control titolo-non-selezionabile" id="receiver" disabled>
                                            <option value="-1" selected>Seleziona un'opzione</option>
                                        </select>
                                        </div>
                                </div>
                                <div id="objectRow" class="form-group row">
                                	<div class="col col-sm-12">
                                        <label for="object">Oggetto:</label>
                                        <input type="text" class="form-control" id="object">
                                    </div>
                                </div>
                                <div id="messageRow" class="form-group row">
                                	<div class="col col-sm-12">
                                        <label for="message">Messaggio:</label>
                                        <textarea class="form-control" rows="5" id="message"></textarea>
                                        <br>
                                    </div>
                                </div>
                                <div id="copyRow" class="form-group row">
                                	<div class="col col-sm-12">
                                        <input id="sendCopy" type="checkbox" value="1">
                                        <label for="sendCopy">Ricevi una copia dell'email inviata</label>
                                        <br>
                                    </div>
                                </div>
                                <button id="sendButton" class="btn btn-primary" type="submit" disabled>Invia</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>