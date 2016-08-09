<?php
 
    include '../../../../functions.php';
    
    $connection = dbConnection("../../../../../");
    
    $preferenza = $connection->escape_string($_POST['nome']);
    
    $Query = "INSERT INTO `preferenza` (`nome`) VALUES ('$preferenza')";
    
    if (!$connection->query($Query))
    {
        echo "invio dei dati NON riuscito";
    }
    else
    {
        echo "invio dei dati riuscito!";
    }

