<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $idstudente = $_POST['idstudente'];
    $idnuovotutor = $_POST['idtutor'];
    
    $query = "UPDATE `studente` SET `tutor_id_tutor` = $idnuovotutor WHERE `id_studente` = $idstudente";
    if ($conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo "non ok";
    }
?>