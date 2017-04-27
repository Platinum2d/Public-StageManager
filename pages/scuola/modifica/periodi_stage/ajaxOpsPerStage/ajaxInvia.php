<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    $inizio = trim($conn->escape_string(strip_tags($_POST['inizio'])));
    $inizio = date("Y-m-d", strtotime($inizio));
    $fine = trim($conn->escape_string(strip_tags($_POST['fine'])));
    $fine = date("Y-m-d", strtotime($fine));
        
    $query = "UPDATE stage SET inizio_stage = '$inizio', fine_stage = '$fine' WHERE id_stage = $id";
    
    if($inizio <= $fine && $conn->query($query))
        echo "ok";
    else
        echo $conn->error;