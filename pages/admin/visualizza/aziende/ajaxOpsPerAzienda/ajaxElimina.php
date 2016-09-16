<?php

    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    
    $idazienda = $_POST['idazienda'];
    
    $error = false;
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    $query = "DELETE FROM `azienda` WHERE `id_azienda` = $idazienda";
    if (!$conn->query($query)){ $error = true; }
    
    $query = "UPDATE `studente` SET `azienda_id_azienda` = NULL WHERE `azienda_id_azienda` = $idazienda";
    if (!$conn->query($query)){ $error = true; }
    
    $query = "UPDATE `tutor` SET `azienda_id_azienda` = NULL WHERE `azienda_id_azienda` = $idazienda";
    if (!$conn->query($query)){ $error = true; }
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    
    if ($error)
        echo "non ok";
    else
        echo "ok";