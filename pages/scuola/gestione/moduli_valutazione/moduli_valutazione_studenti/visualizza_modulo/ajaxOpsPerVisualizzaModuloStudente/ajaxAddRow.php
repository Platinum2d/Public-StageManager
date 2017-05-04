<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $nomeriga = $conn->escape_string($_POST['nome']);
    $posizione = intval($_POST['posizione']);
    $idmodulo = intval($_POST['modulo']);
    
    $query = "INSERT INTO riga_modulo_studente "
            . "(descrizione, numero_voce, modulo_valutazione_studente_id_modulo_valutazione_studente) "
            . "VALUES ('$nomeriga', $posizione, $idmodulo)";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;