<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $idlavoro = $_POST['idlavoro'];
    
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    
    $query = "DELETE FROM `lavoro_giornaliero` WHERE `id_lavoro_giornaliero` = $idlavoro";
    if ($conn->query($query))
    {
        echo "ok";
    }
    
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");