<?php
	include "../../../functions.php";
    $id = $_POST ['id'];
    $scelta = $_POST ['visita'];

    $connessione = dbConnection("../../../../");
    $sql = "UPDATE `studente_has_stage` SET `visita_azienda`=$scelta WHERE `id_studente_has_stage`=$id;";
    $connessione->query ( $sql );
?>