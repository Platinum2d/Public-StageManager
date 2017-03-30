<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $idlavoro = $_POST['idlavoro'];
    
    $query = "DELETE FROM `lavoro_giornaliero` WHERE `id_lavoro_giornaliero` = $idlavoro";
    if ($conn->query($query))
    {
        echo "ok";
    }
?>