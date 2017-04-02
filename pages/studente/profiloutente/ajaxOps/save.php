<?php
    include '../../../functions.php';
    if ($_POST ['first']) 
    {
        $connessione = dbConnection ("../../../../");
        $id_studente = $_SESSION ['userId'];
        $username = $connessione->escape_string ( strip_tags($_POST ['username']));
        $nome = $connessione->escape_string ( strip_tags($_POST ['first']));
        $cognome = $connessione->escape_string ( strip_tags($_POST ['last']) );
        $email = $connessione->escape_string ( strip_tags($_POST ['mail']) );
        $telefono = $connessione->escape_string ( strip_tags($_POST ['phone']) );
        $citta =  $connessione->escape_string(strip_tags($_POST ['city']) );
        
        if ($email == "") {
            $email = "NULL";
        }
        else {
            $email = "'".$email."'";
        }
        if ($telefono == "") {
            $telefono = "NULL";
        }
        else {
            $telefono = "'".$telefono."'";
        }
        if ($citta == "") {
            $citta = "NULL";
        }
        else {
            $citta = "'".$citta."'";
        }
            
        $userquery = "UPDATE utente 
                        SET username = '$username' 
                        WHERE id_utente = $id_studente;";
        $sql = "UPDATE studente 
                SET nome='$nome',cognome='$cognome', citta=$citta, email=$email, telefono=$telefono 
                WHERE id_studente=$id_studente;";
        if ($connessione->query ( $userquery ) && $connessione->query ( $sql ))
            echo "ok";
        else 
            echo $connessione->error;
    }
?>
