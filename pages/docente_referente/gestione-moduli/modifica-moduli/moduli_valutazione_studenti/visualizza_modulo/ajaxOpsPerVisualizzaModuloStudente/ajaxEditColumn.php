<?php

    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idcolonna = $_POST['id'];
    $descrizione = $conn->escape_string($_POST['nome']);
    $posizione = $_POST['posizione'];
    $tiporisposta = $_POST['risposta'];
    
    $query = "UPDATE colonna_modulo_studente "
            . "SET descrizione = '$descrizione', numero_voce = $posizione, risposta_multipla = $tiporisposta "
            . "WHERE id_colonna_modulo_studente = $idcolonna";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;