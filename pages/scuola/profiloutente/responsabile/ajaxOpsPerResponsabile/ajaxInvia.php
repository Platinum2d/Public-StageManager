<?php
    include '../../../../functions.php';
    
    $connessione = dbConnection("../../../../../");
    
    $nome = strip_tags($connessione->escape_string($_POST ['first']));
    $cognome = strip_tags($connessione->escape_string ($_POST ['cognome']));    
    $email = strip_tags($connessione->escape_string ($_POST ['mail']));
    $telefono = strip_tags($connessione->escape_string ($_POST ['phone']));
    
    $nome = ($nome === "") ?  "NULL" :  "'".$nome."'";
    $cognome = ($cognome === "") ? "NULL" :  "'".$cognome."'";
    $email = ($email === "") ? "NULL" :  "'".$email."'";
    $telefono = ($telefono === "") ? "NULL" :  "'".$telefono."'";
    
    $query = "UPDATE `scuola` SET `nome_responsabile` = $nome, `cognome_responsabile` = $cognome, `telefono_responsabile` = $telefono, "
            . "`email_responsabile` = $email WHERE `scuola`.`id_scuola` = ".$_SESSION['userId'];
    
    if ($connessione->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $connessione->error;
    }
    