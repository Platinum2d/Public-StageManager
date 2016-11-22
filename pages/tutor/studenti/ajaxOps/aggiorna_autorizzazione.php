<?php    

    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $permesso = $_POST['permesso'];
    $idstudente = $_POST['studente'];
    
    $query = "UPDATE  `studente_has_stage` SET  `autorizzazione_registro` =  '$permesso' WHERE  `studente_has_stage`.`id_studente_has_stage` = $idstudente;";
    
    if($conn->query($query))
        echo "ok";