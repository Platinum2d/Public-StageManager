<?php
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");
    $idtutor = $_POST['idtutor'];
        
        $query = "SET FOREIGN_KEY_CHECKS = 0";
    $conn->query($query);
        
    $query = "DELETE FROM tutor WHERE id_tutor = $idtutor";
    $conn->query($query);
        
    $query = "UPDATE studente SET tutor_id_tutor = NULL WHERE tutor_id_tutor = $idtutor";
    $conn->query($query);
        
            $query = "SET FOREIGN_KEY_CHECKS = 1";
    $conn->query($query);