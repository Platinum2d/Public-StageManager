<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_doc = $_POST['docente'];
    $id_classe = $_POST['classe'];
    $id_anno = $_POST['anno'];
    
    $query = "SELECT id_studente_has_stage 
              FROM studente_has_stage AS shs, classe_has_stage AS chs 
              WHERE shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage AND 
              chs.classe_id_classe = $id_classe AND
              chs.anno_scolastico_id_anno_scolastico = $id_anno;";
    
    $result = $conn->query($query);
    $errore = false;
    while ($row = $result->fetch_assoc())
    {
        $current_id_studente_has_stage = $row['id_studente_has_stage'];
        $query = "INSERT INTO docente_referente_has_studente_has_stage (docente_id_docente, studente_has_stage_id_studente_has_stage) VALUES ($id_doc, $current_id_studente_has_stage)";
        if (!$conn->query($query))
            $errore = true;
    }
    
    if (!$errore)
        echo "ok";
    else
        echo $conn->error;