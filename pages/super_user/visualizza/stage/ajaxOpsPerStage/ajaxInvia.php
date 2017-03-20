<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    $inizio = trim($conn->escape_string(strip_tags($_POST['inizio'])));
    $inizio = date("Y-m-d", strtotime($inizio));
    $durata = trim($conn->escape_string(strip_tags($_POST['durata'])));
        
    $query = "UPDATE stage SET inizio_stage = '$inizio', durata_stage = $durata WHERE id_stage = $id";
    
    if($conn->query($query))
        echo "ok";
    else
        echo $conn->error;