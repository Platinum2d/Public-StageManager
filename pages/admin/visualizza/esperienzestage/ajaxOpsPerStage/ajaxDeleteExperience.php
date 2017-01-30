<?php

    include '../../../../functions.php'; //Qua che si fa? teniamo o mettiamo il vincolo sulle chiavi?
    $conn = dbConnection("../../../../../");
    
    $classe_has_stage_id = $_POST['id_classe_has_stage'];      
    
    $deletelavoroquery = "DELETE FROM lavoro_giornaliero WHERE studente_has_stage_id_studente_has_stage IN (SELECT id_studente_has_stage FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id)";
    $deletevalutazione_studentequery = "DELETE FROM valutazione_studente WHERE id_valutazione_studente IN (SELECT valutazione_studente_id_valutazione_studente FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id)";
    $deletevalutazione_stagequery = "DELETE FROM valutazione_stage WHERE id_valutazione_stage IN (SELECT valutazione_stage_id_valutazione_stage FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id)";
    $deletestudente_has_stagequery = "DELETE FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id";
    $query = "DELETE FROM classe_has_stage WHERE id_classe_has_stage = $classe_has_stage_id";
    
    if($conn->query("SET FOREIGN_KEY_CHECKS = 0") && $conn->query($deletelavoroquery) && $conn->query($deletevalutazione_studentequery) && $conn->query($deletevalutazione_stagequery) 
            && $conn->query($deletestudente_has_stagequery) && $conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $conn->error;
    }