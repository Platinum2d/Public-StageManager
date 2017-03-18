<?php
    include '../../../functions.php';
    if ($_POST ['first']) 
    {
        $connessione = dbConnection ("../../../../");
        $id_studente = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( strip_tags($_POST ['first']));
        $cognome = $connessione->escape_string ( strip_tags($_POST ['last']) );
        $email = $connessione->escape_string ( strip_tags($_POST ['mail']) );
        $telefono = $connessione->escape_string ( strip_tags($_POST ['phone']) );
        $citta =  $connessione->escape_string(strip_tags($_POST ['city']) );
        $sql = "update studente set nome='$nome',cognome='$cognome', citta='$citta', email='$email', telefono='$telefono' where id_studente='$id_studente';";
        $result = $connessione->query ( $sql );
    }
?>