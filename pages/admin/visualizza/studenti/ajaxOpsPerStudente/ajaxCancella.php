<?php

    include '../../../../functions.php';
    $connessione = dbConnection("../../../../../");
    $id = $_POST['id'];

    $Query = "DELETE FROM `studente` WHERE `id_studente` = $id";
    $userquery = "DELETE FROM `utente` WHERE `id_utente` = $id";
    $connessione->query("SET FOREIGN_KEY_CHECKS = 0");

    if ($connessione->query($userquery) && $connessione->query($Query))
        echo "ok";
    else 
        echo $connessione->error;

    $connessione->query("SET FOREIGN_KEY_CHECKS = 1");
?>