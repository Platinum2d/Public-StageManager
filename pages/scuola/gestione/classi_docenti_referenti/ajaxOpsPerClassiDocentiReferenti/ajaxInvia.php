<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_doc = $_POST['docente'];
    $id_classe = $_POST['classe'];
    $id_anno = $_POST['anno'];
    
    $errore = false;
    
    $stage_query = "SELECT id_classe_has_stage AS id_chs
                    FROM classe_has_stage AS chs  
                    WHERE chs.anno_scolastico_id_anno_scolastico = $id_anno 
                    AND chs.classe_id_classe = $id_classe";
    $result_query = $conn->query($stage_query);
    
    if (is_object($result_query) && $result_query->num_rows > 0)
    {
        while ($row = $result_query->fetch_assoc())
        {
            $idchs = $row['id_chs'];
            
            $insertquery = "INSERT INTO docente_referente_has_classe_has_stage (docente_id_docente, classe_has_stage_id_classe_has_stage) VALUES ($id_doc, $idchs)";
            if (!$conn->query($insertquery)) $errore = true;
        }
        
        if (!$errore)
            echo "ok";
        else
            echo $conn->error;
    }
    else
        echo $stage_query;