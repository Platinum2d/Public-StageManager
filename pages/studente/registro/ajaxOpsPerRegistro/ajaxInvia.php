<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    $idlavoro = $_POST['id'];
    $data = date("Y-m-d", strtotime($_POST['data']));
    $descrizione = $conn->escape_string($_POST['descrizione']);
    
    $query = "UPDATE  `lavoro_giornaliero` SET  `data` =  '$data',`descrizione` =  '$descrizione' WHERE  `id_lavoro_giornaliero` =$idlavoro";
    
    if ($conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $conn->error;
    }
?>