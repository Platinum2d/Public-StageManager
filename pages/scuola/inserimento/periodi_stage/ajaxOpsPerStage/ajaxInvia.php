<?php    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $inizio_stage = ($_POST['inizio']);
    $inizio_stage = date("Y-m-d", strtotime($inizio_stage));   
    $durata = ($_POST['durata']);
        
    $query = "INSERT INTO stage (inizio_stage, durata_stage) VALUES ('$inizio_stage', $durata)";
    $ok = ($connection->query($query)) ? true : false;
        
    if ($ok) echo "ok"; else echo $connection->error;
?>