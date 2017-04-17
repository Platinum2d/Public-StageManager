<?php
include '../../../functions.php';
if ($_POST ['first']) {
    $connessione = dbConnection ("../../../../");
    $id_tutor = $_SESSION ['userId'];
    $username = $connessione->escape_string ( strip_tags(strip_whitespaces($_POST ['username'])));
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
                    WHERE id_utente = $id_tutor";
    $sql = "UPDATE tutor 
            SET nome='$nome',cognome='$cognome', email=$email, telefono=$telefono 
            WHERE id_tutor='$id_tutor';";
    $result = $connessione->query ( $sql );
    if ($connessione->query ( $userquery ) && $connessione->query ( $sql ))
        echo "ok";
    else 
        echo $connessione->error;
}
?>