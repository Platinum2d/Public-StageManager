<?php
    include '../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../");
        $id_docente = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( strip_tags($_POST ['first']));
        $cognome = $connessione->escape_string ( strip_tags($_POST ['last']) );
        $email = $connessione->escape_string ( strip_tags($_POST ['mail']) );
        $telefono = $connessione->escape_string ( strip_tags($_POST ['phone']) );
        $sql = "UPDATE super_user SET nome='$nome', cognome='$cognome', email='$email', telefono='$telefono' where id_super_user='$id_docente';";
        $result = $connessione->query ( $sql );
    }
?>