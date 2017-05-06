<?php

    include "../../../../../functions.php";
    $conn = dbConnection("../../../../../../");
    
    $id_drhchs = $_POST['drhchs'];
    
    $query = "DELETE FROM docente_referente_has_classe_has_stage WHERE id_docente_has_classe_has_stage = $id_drhchs";
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;