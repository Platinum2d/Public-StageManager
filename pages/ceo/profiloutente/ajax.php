<?php
    include '../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../");
        $id_az = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( strip_tags($_POST ['first']));
        $cognome = $connessione->escape_string ( strip_tags($_POST ['last']) );
        $email = $connessione->escape_string ( strip_tags($_POST ['mail']) );
        $telefono = $connessione->escape_string ( strip_tags($_POST ['phone']) );
        $sql = "update azienda set nome_responsabile='$nome',cognome_responsabile='$cognome', email_responsabile='$email', telefono_responsabile='$telefono' where id_azienda='$id_az';";
        $result = $connessione->query ( $sql );
    }
?>