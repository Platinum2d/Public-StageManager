<?php
    include "../../functions.php";

    $connessione = dbConnection ("../../../");
    $voto = intval($_POST['voto']);
    $descrizione = $connessione->escape_string($_POST['descrizione']);
    
    $query = "INSERT INTO `valutazione_applicazione` (`voto`, `descrizione`, `id_utente`, `tipo_utente`) VALUES ($voto,'".trim($descrizione)."', '".$_SESSION['userId']."', '".$_SESSION['nameTable']."')";
    if($connessione->query($query))
        echo "ok";
    else
        echo $connessione->error;