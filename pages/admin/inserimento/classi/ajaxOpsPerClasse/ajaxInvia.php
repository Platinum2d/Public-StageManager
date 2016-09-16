<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $classe = $connection->escape_string($_POST['nome']);
    
    if(!$connection->query("SET FOREIGN_KEY_CHECKS=0"))
    {
        echo "inserimento dei dati NON riuscito";
    }
    else
    {        
        $Query = "INSERT INTO `classe` (`nome`) VALUES ('$classe')";
        if(!$connection->query($Query))
        {
            echo "inserimento dei dati NON riuscito $Query";
            $connection->query("SET FOREIGN_KEY_CHECKS=1");
        }
        else
        {
            echo "Inserimento dei dati riuscito!";
            $connection->query("SET FOREIGN_KEY_CHECKS=1");
        }
    }
    
    
    
