<?php
    include '../../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../../");
        $id_az = $_SESSION ['userId'];
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
                        WHERE id_utente = $id_az;";
        $sql = "UPDATE azienda 
                SET nome_responsabile='$nome',cognome_responsabile='$cognome', email_responsabile=$email, telefono_responsabile=$telefono 
                WHERE id_azienda=$id_az;";
        if ($connessione->query ( $userquery ) && $connessione->query ( $sql ))
            echo "ok";
        else 
            echo $connessione->error;
    }
?>