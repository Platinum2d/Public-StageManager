<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $data = date("Y-m-d", strtotime($_POST['data']));
    $descrizione = $conn->escape_string($_POST['descrizione']);
    $idStudtudenteHasStage = $_SESSION ['studenteHasStageId'];
    
    $query = "INSERT INTO `lavoro_giornaliero` (data,descrizione,studente_has_stage_id_studente_has_stage) 
            VALUES ('$data','$descrizione',$idStudtudenteHasStage)";
    
    if($conn->query($query)) {
        $query = "SELECT MAX(id_lavoro_giornaliero) FROM lavoro_giornaliero";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        echo $row['MAX(id_lavoro_giornaliero)'];
    }
?>