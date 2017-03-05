<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $classe = $connection->escape_string($_POST['nome']);
    $idscuola = $_SESSION['userId'];
    $idsettore = $_POST['settore'];
    
    if(!$connection->query("SET FOREIGN_KEY_CHECKS=0"))
    {
        echo "inserimento dei dati NON riuscito";
    }
    else
    {        
        $Query = "INSERT INTO `classe` (`nome`, `scuola_id_scuola`,`settore_id_settore`) VALUES ('$classe', $idscuola,  $idsettore)";
        if(!$connection->query($Query))
        {
            echo "inserimento dei dati NON riuscito ".$connection->error."";
            $connection->query("SET FOREIGN_KEY_CHECKS=1");
        }
        else
        {
            echo "Inserimento dei dati riuscito!";
            $connection->query("SET FOREIGN_KEY_CHECKS=1");
        }
    }
?>