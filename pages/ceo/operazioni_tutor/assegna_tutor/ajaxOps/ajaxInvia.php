<?php

    include "../../../../functions.php";
    $conn = dbConnection ("../../../../../");
    
    $studente_has_stage = $_POST['studente_has_stage'];
    $id_tutor = ($_POST['id_tutor'] === "-1") ? "NULL" : $_POST['id_tutor'];
    
    $query = "UPDATE studente_has_stage SET tutor_id_tutor = $id_tutor WHERE id_studente_has_stage = $studente_has_stage";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;