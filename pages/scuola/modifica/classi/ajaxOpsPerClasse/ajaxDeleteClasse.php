<?php

    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $query = "UPDATE classe SET nome = '$nomeclasse', scuola_id_scuola = $idscuola, settore_id_settore = $idsettore WHERE id_classe = $idclasse";
    
    if ($conn->query("SET FOREIGN_KEY_CHECKS = 0") && $conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo "non ok";
    }

