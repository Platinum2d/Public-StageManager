<?php
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");    //??
    $id_settore_has_figura = $_POST['id'];
    
    $query = "DELETE FROM settore_has_figura_professionale WHERE id_settore_has_figura_professionale = $id_settore_has_figura";
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;