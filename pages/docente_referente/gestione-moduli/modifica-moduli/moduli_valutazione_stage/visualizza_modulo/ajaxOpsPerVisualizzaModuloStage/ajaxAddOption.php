<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $numero_voce = $_POST['posizione'];
    $opzione = $_POST['opzione'];
    $colonna = $_POST['colonna'];
    
    $query = "INSERT INTO `possibile_risposta_colonna_stage` (numero_voce, opzione, colonna_modulo_stage_id_colonna_modulo_stage) "
            . "VALUES ($numero_voce, '$opzione', $colonna)";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;