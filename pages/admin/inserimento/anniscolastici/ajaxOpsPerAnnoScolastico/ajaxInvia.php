<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $annoscolastico = $connection->escape_string($_POST['nome']);
    
    $query = "INSERT INTO anno_scolastico (nome_anno, corrente) VALUES ('$annoscolastico', 0)";
    $ok = ($connection->query($query)) ? true : false;
    
    if ($ok) echo "ok"; else echo $connection->error;
?>