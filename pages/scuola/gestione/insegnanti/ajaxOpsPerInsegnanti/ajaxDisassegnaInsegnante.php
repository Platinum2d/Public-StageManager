<?php

    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_chd = $_POST['chd'];
    
    $query = "DELETE FROM classe_has_docente WHERE id_classe_has_docente = $id_chd";
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;