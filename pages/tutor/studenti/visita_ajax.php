<?php
    include '../../functions.php';
    $id = $_POST ['id_studente'];
    $scelta = $_POST ['scelta'];
    $page = $_POST ['page'];
    if ($scelta == 1) {
        $connessione = dbConnection ("../../../");
        $sql = "UPDATE `studente` SET `visita_azienda`=1 WHERE `id_studente`=$id";
        $connessione->query ( $sql );
    }
    if ($page == 1) {
        header ( "Location: registro.php?id_studente=$id" );
    } else if ($page == 2) {
        header ( "Location: valuta_studente.php?id_studente=$id" );
    }
?>