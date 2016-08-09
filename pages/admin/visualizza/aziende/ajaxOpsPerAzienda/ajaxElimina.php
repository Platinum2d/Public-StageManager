<?php

    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    
    $idazienda = $_POST['idazienda'];
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    $query = "DELETE FROM azienda WHERE id_azienda = $idazienda";
    $conn->query($query);
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");