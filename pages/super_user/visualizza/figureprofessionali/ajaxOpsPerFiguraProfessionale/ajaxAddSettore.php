<?php
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../"); //????   
    $id_settore = $_POST['settore'];
    $id_figura = $_POST['figura'];
    
    $query = "INSERT INTO settore_has_figura_professionale (settore_id_settore, figura_professionale_id_figura_professionale) VALUES ($id_settore, $id_figura)";
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;