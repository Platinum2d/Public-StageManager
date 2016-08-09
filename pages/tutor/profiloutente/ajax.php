<?php
include '../../functions.php';
if ($_POST ['first']) {
    $connessione = dbConnection ("../../../");
    $id_tutor = $_SESSION ['userId'];
    $nome = $connessione->escape_string ( $_POST ['first'] );
    $cognome = $connessione->escape_string ( $_POST ['last'] );
    $email = $connessione->escape_string ( $_POST ['mail'] );
    $telefono = $connessione->escape_string ( $_POST ['phone'] );
    $sql = "update tutor set nome='$nome',cognome='$cognome', email='$email', telefono='$telefono' where id_tutor='$id_tutor';";
    $result = $connessione->query ( $sql );
    echo $sql;
}
?>