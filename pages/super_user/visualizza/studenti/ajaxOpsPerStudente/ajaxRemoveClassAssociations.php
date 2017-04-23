<?php
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    $classe = $_POST['classe']; //
    $anno = $_POST['anno'];
    
    $query_chd = "DELETE FROM classe_has_docente WHERE classe_id_classe = $classe AND anno_scolastico_id_anno_scolastico = $anno";
    $query_chs = "DELETE FROM classe_has_stage WHERE classe_id_classe = $classe AND anno_scolastico_id_anno_scolastico = $anno";
    $query_classe = "DELETE FROM `classe` WHERE `classe`.`id_classe` = $classe";
    
    if ($conn->query($query_chd) && $conn->query($query_chs) && $conn->query($query_classe))
        echo "ok";
    else 
        echo $conn->error;