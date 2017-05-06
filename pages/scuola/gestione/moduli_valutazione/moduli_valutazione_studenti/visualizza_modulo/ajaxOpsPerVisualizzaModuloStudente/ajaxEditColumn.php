<?php

    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idcolonna = $_POST['id'];
    $descrizione = $conn->escape_string($_POST['nome']);
    $posizione = $_POST['posizione'];
    $tiporisposta = intval($_POST['risposta']);
    
    $errore = false;
    
    if ($tiporisposta === 0)
    {
        $query_opzioni = "DELETE FROM possibile_risposta_colonna_studente WHERE colonna_modulo_studente_id_colonna_modulo_studente = $idcolonna";
        if (!$conn->query($query_opzioni)) $errore = true; 
    }
    
    $query = "UPDATE colonna_modulo_studente "
            . "SET descrizione = '$descrizione', numero_voce = $posizione, risposta_multipla = $tiporisposta "
            . "WHERE id_colonna_modulo_studente = $idcolonna";
    
    if (!$errore && $conn->query($query))
        echo "ok";
    else
        echo $conn->error;