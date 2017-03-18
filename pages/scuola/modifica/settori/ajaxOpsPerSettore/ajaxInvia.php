<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    $indirizzo = trim($conn->escape_string(strip_tags($_POST['indirizzo'])));
    $settore = trim($conn->escape_string(strip_tags($_POST['settore'])));
    
    $query = "UPDATE settore SET indirizzo_studi = '$indirizzo', nome_settore = '$settore' WHERE id_settore = $id";
    
    if($conn->query($query))
        echo "ok";
    else
        echo $conn->error;