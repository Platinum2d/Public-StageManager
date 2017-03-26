<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_drhshs = $_POST['drhshs'];
    
    $query = "DELETE FROM docente_referente_has_studente_has_stage WHERE id_docente_has_studente_has_stage = $id_drhshs";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;