<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    $idlavoro = intval($_POST['id']);
    $data = date("Y-m-d", strtotime($_POST['data']));
    $lavoro = $conn->escape_string($_POST['lavoro']);
    $insegnamenti = $conn->escape_string($_POST['insegnamenti']);
    $commento = $conn->escape_string($_POST['commento']);
    
    if (empty($commento)) {
        $commento = "NULL";
    }
    else {
        $commento = "'".$commento."'";
    }
    
    $query = "UPDATE lavoro_giornaliero 
                SET data=$data, lavoro_svolto='$lavoro', insegnamenti='$insegnamenti', commento=$commento 
                WHERE id_lavoro_giornaliero=$idlavoro;";
    
    if ($conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $conn->error;
    }
?>