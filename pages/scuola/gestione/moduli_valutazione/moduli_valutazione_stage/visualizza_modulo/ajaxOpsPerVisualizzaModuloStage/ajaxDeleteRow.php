<?php

    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idriga = $_POST['riga'];
    
    $errore = false;
    $risposte_query = "DELETE FROM risposta_voce_modulo_stage WHERE riga_modulo_stage_id_riga_modulo_stage = $idriga";
    
    if ($conn->query($risposte_query))
    {
        $query = "DELETE FROM riga_modulo_stage WHERE id_riga_modulo_stage = $idriga";
        if (!$conn->query($query))
            $errore = true;
    }
    else
        $errore = true;
    
    if (!$errore)
        echo "ok";
    else 
        echo $conn->error;