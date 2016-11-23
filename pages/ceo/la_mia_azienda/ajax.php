<?php
    include '../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../");
        $id_az = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( $_POST ['first'] );
        $citta = $connessione->escape_string ( $_POST ['city'] );
        $indirizzo = $connessione->escape_string ( $_POST ['address'] );
        $email = $connessione->escape_string ( $_POST ['mail'] );
        $telefono = $connessione->escape_string ( $_POST ['phone'] );
        $sql = "update azienda set nome_aziendale='$nome',citta_aziendale='$citta', indirizzo='$indirizzo', email_aziendale='$email', telefono_aziendale='$telefono' where id_azienda='$id_az';";
        $result = $connessione->query ( $sql );
    }
?>