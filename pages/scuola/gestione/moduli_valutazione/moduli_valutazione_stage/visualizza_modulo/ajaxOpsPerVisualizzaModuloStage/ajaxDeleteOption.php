<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idopzione = $_POST['opzione'];

    $query = "DELETE FROM possibile_risposta_colonna_stage WHERE id_possibile_risposta_colonna_stage = $idopzione";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;