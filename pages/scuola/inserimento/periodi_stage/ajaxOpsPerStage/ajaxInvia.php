<?php    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $inizio_stage = ($_POST['inizio']);
    $inizio_stage = date("Y-m-d", strtotime($inizio_stage));   
    $fine_stage = ($_POST['fine']);
    $fine_stage = date("Y-m-d", strtotime($fine_stage));
    $scuola = $_SESSION['userId'];
        
    $query = "INSERT INTO stage (inizio_stage, fine_stage, scuola_id_scuola) VALUES ('$inizio_stage', '$fine_stage', $scuola)";
    $ok = ($connection->query($query)) ? true : false;
        
    if ($ok) echo "ok"; else echo $connection->error;
?>