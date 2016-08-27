<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idstudente = $_POST['idstudente'];
    
    $query = "UPDATE `studente` SET `tutor_id_tutor` = NULL WHERE `id_studente` = $idstudente";
    if ($conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo "non ok";
    }