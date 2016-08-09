<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    $idtutor = $_POST['idtutor'];
    
    $query = "DELETE FROM tutor WHERE id_tutor = $idtutor";
    $conn->query($query);
    
    $query = "UPDATE studente SET tutor_id_tutor = NULL WHERE tutor_id_tutor = $idtutor";
    $conn->query($query);