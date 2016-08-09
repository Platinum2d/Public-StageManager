<?php
    include '../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ();
        $id_docente = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( $_POST ['first'] );
        $cognome = $connessione->escape_string ( $_POST ['last'] );
        $email = $connessione->escape_string ( $_POST ['mail'] );
        $telefono = $connessione->escape_string ( $_POST ['phone'] );
        $sql = "update docente set nome='$nome',cognome='$cognome', telefono='$telefono', email='$email' where id_docente='$id_docente';";
        $result = $connessione->query ( $sql );
    }
?>