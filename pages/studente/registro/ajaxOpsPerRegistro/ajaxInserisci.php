<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $data = date("Y-m-d", strtotime($_POST['data']));
    $lavoro = $conn->escape_string($_POST['lavoroSvolto']);
    $insegnamenti = $conn->escape_string($_POST['insegnamenti']);
    $commento = $conn->escape_string($_POST['commento']);
    $idStudtudenteHasStage = $_SESSION ['studenteHasStageId'];
    
    if ($commento == "" ) {
    	$commento = "NULL";
    }
    else {
    	$commento = "'".$commento."'";
    }
    
    $query = "INSERT INTO `lavoro_giornaliero` (data,lavoro_svolto,insegnamenti,commento,studente_has_stage_id_studente_has_stage) 
            VALUES ('$data','$lavoro','$insegnamenti',$commento,$idStudtudenteHasStage)";
    
    if($conn->query($query)) {
        echo $conn->insert_id;
    }
?>