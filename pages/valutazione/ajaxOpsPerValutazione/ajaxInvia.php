<?php
    include "../../functions.php";

    $connessione = dbConnection ("../../../");
    $voto = intval($_POST['voto']);
    $descrizione = $connessione->escape_string($_POST['descrizione']);
    
    $query = "INSERT INTO `valutazione_applicazione` (`voto`, `descrizione`, `utente_id_utente`) VALUES ($voto,'".trim($descrizione)."', '".$_SESSION['userId']."')";
    if($connessione->query($query))
        echo "ok";
    else
        echo $connessione->error;