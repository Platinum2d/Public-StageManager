<?php

    include '../../../../../functions.php';
    $conn = dbConnection("../../../../../../");
    
    $modulo_stage = $_POST['modulo_stage'];
    $modulo_studente = $_POST['modulo_studente'];
    $chs = $_POST['chs'];
    
    $modulo_stage = ($modulo_stage === "-1") ? "NULL" : $modulo_stage;
    $modulo_studente = ($modulo_studente === "-1") ? "NULL" : $modulo_studente;
    
    $query = "UPDATE classe_has_stage "
            . "SET modulo_valutazione_studente_id_modulo_valutazione_studente = $modulo_studente, "
            . "modulo_valutazione_stage_id_modulo_valutazione_stage = $modulo_stage "
            . "WHERE id_classe_has_stage = $chs";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;