<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $nomecolonna = $conn->escape_string($_POST['nome']);
    $posizione = intval($_POST['posizione']);
    $risposta_multipla = intval($_POST['risposta_multipla']);
    $idmodulo = intval($_POST['modulo']);
    
    $query = "INSERT INTO colonna_modulo_stage "
            . "(descrizione, numero_voce, risposta_multipla, modulo_valutazione_stage_id_modulo_valutazione_stage) "
            . "VALUES ('$nomecolonna', $posizione, $risposta_multipla, $idmodulo)";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;