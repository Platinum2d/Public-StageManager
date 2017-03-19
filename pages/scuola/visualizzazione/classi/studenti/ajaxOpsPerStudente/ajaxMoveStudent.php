<?php

    include '../../../../../functions.php';        
    $connessione = dbConnection("../../../../../../");
    
    $idclassenuova = $_POST['classenuova'];
    $idclassevecchia = $_POST['classevecchia'];
    $idanno = $_POST['anno'];
    $idstudente = $_POST['studente'];
    
    $query = "UPDATE studente_attends_classe SET classe_id_classe = $idclassenuova WHERE studente_id_studente = $idstudente AND anno_scolastico_id_anno_scolastico = $idanno"
            . " AND classe_id_classe = $idclassevecchia";
    
    if ($connessione->query($query))
        echo "ok";
    else
        echo $connessione->error;