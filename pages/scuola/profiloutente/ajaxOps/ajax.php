<?php
    include '../../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../../");
        $id_scuola = $_SESSION ['userId'];
        $username = strip_tags($connessione->escape_string ($_POST ['username']));
        $nome = strip_tags($connessione->escape_string($_POST ['first']));
        $email = strip_tags($connessione->escape_string ($_POST ['mail']));
        $telefono = strip_tags($connessione->escape_string ($_POST ['phone']));
        $citta = strip_tags($connessione->escape_string ($_POST ['citta']));
        $CAP = strip_tags($connessione->escape_string ($_POST ['CAP']));
        $sitoweb = strip_tags($connessione->escape_string ($_POST ['sitoweb']));
        
        $email = ($email === "") ?  "NULL" :  "'".$email."'";
        $telefono = ($telefono === "") ? "NULL" :  "'".$telefono."'";
        $citta = ($citta === "") ? "NULL" :  "'".$citta."'";
        $CAP = ($CAP === "") ? "NULL" :  "'".$CAP."'";
        $sitoweb = ($sitoweb === "") ? "NULL" :  "'".$sitoweb."'";
        
        $userquery = "UPDATE utente 
                        SET username = '$username' 
                        WHERE id_utente = $id_scuola";
        
        $sql = "UPDATE scuola 
                SET nome = '$nome', telefono = $telefono, email = $email, citta = $citta, CAP = $CAP, sito_web = $sitoweb 
                WHERE id_scuola = $id_scuola;";
        if ($connessione->query ( $userquery ) && $connessione->query ( $sql ))
            echo "ok";
        else 
            echo $sql;
    }
?>