<?php
    include '../../../functions.php';
    $db = dbConnection("../../../../");

    $id =  ( $_POST ['sid'] );
    $query = "DELETE FROM `lavoro_giornaliero` WHERE `id_lavoro_giornaliero`=$id";
    if ($db->query ( $query )) {
        echo "0";
    } else {
         echo "1";
    }
?>