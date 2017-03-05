<?php
    include "../../pages/functions.php";
    $connessione = dbConnection("../../");
    
    $categoria = $_POST['categoria'];
    $oggetto = $_POST['oggetto'];
    $messaggio = $_POST['messaggio'];
    $id_utente = $_SESSION ['userId'];
    $timestamp = time ();
    $data = date ('Y-m-d', $timestamp);
    $ora = date ('G:i:s', $timestamp);
    
    $query = "INSERT INTO `segnala_problema` (categoria, oggetto, descrizione, data, ora, utente_id_utente)
    VALUES ('$categoria','$oggetto','$messaggio','$data','$ora',$id_utente);";
    $result = $connessione->query($query);
    if($result)
    {
        echo 0;
    }
    else {
        echo 1;
    }
?>