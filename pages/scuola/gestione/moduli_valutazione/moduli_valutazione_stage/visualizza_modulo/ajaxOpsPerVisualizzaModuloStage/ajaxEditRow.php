<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idriga = $_POST['id'];
    $descrizione = $conn->escape_string($_POST['nome']);
    $posizione = $_POST['posizione'];
    
    $query = "UPDATE `riga_modulo_stage` "
            . "SET `descrizione` = '$descrizione', `numero_voce` = $posizione "
            . "WHERE `id_riga_modulo_stage` = $idriga";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;