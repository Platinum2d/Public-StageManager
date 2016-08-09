<?php
 
    include '../../../../functions.php';
    
    $connection = dbConnection("../../../../../");
    
    $specializzazione = $connection->escape_string($_POST['nome']);
    
    $Query = "INSERT INTO `specializzazione` (`nome`) VALUES ('$specializzazione')";
    
    if (!$connection->query($Query))
    {
        echo "invio dei dati NON riuscito";
    }
    else
    {
        echo "Inserimento dei dati riuscito!";
    }

