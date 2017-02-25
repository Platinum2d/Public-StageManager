<?php

    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    
    $idstage = $_POST['stage'];
    $idclasse = $_POST['classe'];
    $idanno = $_POST['anno'];
    
    $query = "INSERT INTO classe_has_stage (stage_id_stage, classe_id_classe, anno_scolastico_id_anno_scolastico) VALUES ($idstage, $idclasse, $idanno)";
    
    if($conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $conn->error;
    }

