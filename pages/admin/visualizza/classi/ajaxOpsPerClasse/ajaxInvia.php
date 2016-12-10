<?php

    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $idclasse = $_POST['id'];
    $nomeclasse = $conn->escape_string($_POST['nomeclasse']);
    $idscuola = $_POST['scuola'];
    $idsettore = $_POST['settore'];
    
    $query = "UPDATE classe SET nome = '$nomeclasse', scuola_id_scuola = $idscuola, settore_id_settore = $idsettore WHERE id_classe = $idclasse";
    
    if ($conn->query("SET FOREIGN_KEY_CHECKS = 0") && $conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo "non ok";
    }