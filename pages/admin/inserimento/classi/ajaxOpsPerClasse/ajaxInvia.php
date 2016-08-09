<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $classe = $connection->escape_string($_POST['nome']);
    $specializzazione = $connection->escape_string($_POST['specializzazione']);
    
    if(!$connection->query("SET FOREIGN_KEY_CHECKS=0"))
    {
        echo "inserimento dei dati NON riuscito";
    }
    else
    { 
        $Query = "INSERT INTO `classe` (`nome`, `specializzazione_id_specializzazione`) VALUES ('$classe', (SELECT id_specializzazione FROM specializzazione WHERE nome = '$specializzazione'))";
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
    
    
    
