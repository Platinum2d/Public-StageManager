<?php
    include '../../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../../");
        $id_docente = $_SESSION ['userId'];
        $username = $connessione->escape_string ( strip_tags($_POST ['username']));
        $nome = $connessione->escape_string ( strip_tags($_POST ['first']));
        $cognome = $connessione->escape_string ( strip_tags($_POST ['last']) );
        $email = $connessione->escape_string ( strip_tags($_POST ['mail']) );
        $telefono = $connessione->escape_string ( strip_tags($_POST ['phone']) );
        
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
            
        $userquery = "UPDATE utente 
                        SET username = '$username' 
                        WHERE id_utente = $id_docente";
        $sql = "UPDATE docente 
                SET nome='$nome',cognome='$cognome', telefono=$telefono, email=$email 
                WHERE id_docente=$id_docente;";
        if ($connessione->query ( $userquery ) && $connessione->query ( $sql ))
            echo "ok";
        else 
            echo $connessione->error;
    }
?>