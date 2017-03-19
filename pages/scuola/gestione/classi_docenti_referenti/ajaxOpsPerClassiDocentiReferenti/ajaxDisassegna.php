<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_doc = $_POST['docente'];
    $id_classe = $_POST['classe'];
    $id_anno = $_POST['anno'];
    
    $query = "DELETE FROM docente_referente_has_studente_has_stage
              WHERE docente_id_docente = $id_doc 
              AND studente_has_stage_id_studente_has_stage 
              IN (SELECT id_studente_has_stage 
                  FROM studente_has_stage AS shs, classe_has_stage AS chs 
                  WHERE shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                  AND chs.classe_id_classe = $id_classe 
                  AND chs.anno_scolastico_id_anno_scolastico = $id_anno)";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;