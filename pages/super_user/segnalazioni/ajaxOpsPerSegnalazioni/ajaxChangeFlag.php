<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $idsegnalazione = $_POST['id'];
    $nuovostato = intval($_POST['stato']);
    
    $query = "UPDATE segnala_problema SET risolto = $nuovostato WHERE id_segnala_problema = $idsegnalazione";
    if ($conn->query($query))
    {
        echo "ok";
    }
    else
        echo $conn->error;