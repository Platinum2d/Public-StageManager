<?php    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $indirizzo_studi = $_POST['indirizzostudi'];
    $nome_settore = $_POST['nomesettore'];
        
    $query = "INSERT INTO settore (indirizzo_studi, nome_settore) VALUES ('$indirizzo_studi', '$nome_settore')";
    $ok = ($connection->query($query)) ? true : false;
        
    if ($ok) echo "ok"; else echo $connection->error;