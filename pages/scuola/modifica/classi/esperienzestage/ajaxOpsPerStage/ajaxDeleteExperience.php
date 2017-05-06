<?php

    include '../../../../../functions.php'; //Qua che si fa? teniamo o mettiamo il vincolo sulle chiavi?
    $conn = dbConnection("../../../../../../");
    
    $classe_has_stage_id = $_POST['id_classe_has_stage'];      
    
    $deletelavoroquery = "DELETE FROM lavoro_giornaliero WHERE studente_has_stage_id_studente_has_stage IN (SELECT id_studente_has_stage FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id)";
    $deletevalutazionestudente = "DELETE FROM risposta_voce_modulo_studente WHERE studente_has_stage_id_studente_has_stage IN (SELECT id_studente_has_stage FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id)";
    $deletevalutazionestage = "DELETE FROM risposta_voce_modulo_stage WHERE studente_has_stage_id_studente_has_stage IN (SELECT id_studente_has_stage FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id)";
    $delete_drhchs = "DELETE FROM docente_referente_has_classe_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id";
    
    $deletestudente_has_stagequery = "DELETE FROM studente_has_stage WHERE classe_has_stage_id_classe_has_stage = $classe_has_stage_id";
    $query = "DELETE FROM classe_has_stage WHERE id_classe_has_stage = $classe_has_stage_id";
    
    if ($conn->query($deletelavoroquery) && $conn->query($deletevalutazionestudente) && $conn->query($deletevalutazionestage) && $conn->query($delete_drhchs) && $conn->query($deletestudente_has_stagequery) && $conn->query($query))
        echo "ok";
    else
        echo $conn->error;