<?php
    include "../../pages/functions.php";
    $connessione = dbConnection("../../");
    
    $categoria = $_POST['categoria'];
    $oggetto = $_POST['oggetto'];
    $messaggio = $_POST['messaggio'];
    $id_utente = $_SESSION ['userId'];
    
    $query = "INSERT INTO `segnala_problema` (categoria, oggetto, descrizione, utente_id_utente)
                VALUES ('$categoria','$oggetto','$messaggio',$id_utente);";
    if($connessione->query($query))
    {
        echo 0;
    }
    else {
        echo 1;
    }
?>