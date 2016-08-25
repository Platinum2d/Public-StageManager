<?php

    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idazienda = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "UPDATE `azienda` SET `password` = '$password' WHERE `id_azienda` = $idazienda";
    if($conn->query($query))
        echo "ok";
    else
        echo "non ok";