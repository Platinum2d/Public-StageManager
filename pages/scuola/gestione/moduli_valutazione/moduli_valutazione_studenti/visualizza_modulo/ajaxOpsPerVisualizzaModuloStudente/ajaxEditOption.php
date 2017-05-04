<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $id_possibilita = $_POST['id'];
    $numero_voce = $_POST['posizione'];
    $opzione = $_POST['opzione'];
    
    $query = "UPDATE `possibile_risposta_colonna_studente` "
            . "SET `numero_voce` = $numero_voce, `opzione` = '$opzione' "
            . "WHERE `id_possibile_risposta_colonna_studente` = $id_possibilita";
    
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;