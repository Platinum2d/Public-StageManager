<?php

    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idriga = $_POST['riga'];
    
    $errore = false;
    $risposte_query = "DELETE FROM risposta_voce_modulo_studente WHERE riga_modulo_studente_id_riga_modulo_studente = $idriga";
    
    if ($conn->query($risposte_query))
    {
        $query = "DELETE FROM riga_modulo_studente WHERE id_riga_modulo_studente = $idriga";
        if ($conn->query($query))
            $errore = false;
        else
            $errore = true;
    }
    else
        $errore = true;
    
    if (!$errore)
        echo "ok";
    else 
        echo $conn->error;