<?php
    include "../../functions.php";

    $connessione = dbConnection ("../../../");
    $voto = intval($_POST['voto']);
    $descrizione = $connessione->escape_string($_POST['descrizione']);
    
    $query = "UPDATE `valutazione_applicazione` SET `voto` = $voto, `descrizione` = '$descrizione' WHERE `utente_id_utente` = ".$_SESSION['userId']."";
    if($connessione->query($query))
        echo "ok";
    else
        echo $connessione->error;