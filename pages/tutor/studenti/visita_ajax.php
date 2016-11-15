<?php
    include '../../functions.php';
    $id = $_POST ['id_studente_has_stage'];
    $scelta = $_POST ['scelta'];
    $page = $_POST ['page'];
    if ($scelta == 1) {
        $connessione = dbConnection ("../../../");
        $sql = "UPDATE `studente_has_stage` SET `visita_azienda`=1 WHERE `id_studente_has_stage`=$id";
        $connessione->query ( $sql );
    }
    if ($page == 1) {
        header ( "Location: registro.php?shs=$id" );
    } else if ($page == 2) {
        header ( "Location: valuta_studente.php?shs=$id" );
    }
?>