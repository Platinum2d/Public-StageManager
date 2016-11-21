<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $annoscolastico = $connection->escape_string($_POST['nome']);
    $corrente = ($_POST['corrente'] === "true") ? "1" : "0";
    
    $query = "INSERT INTO anno_scolastico (nome_anno, corrente) VALUES ('$annoscolastico', $corrente)";
    $ok = ($connection->query($query)) ? true : false;
    
    if ($ok) echo "ok"; else echo $connection->error;