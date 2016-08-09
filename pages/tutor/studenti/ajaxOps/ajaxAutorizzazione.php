<?php    

    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $permesso = $_POST['permesso'];
    $idstudente = $_POST['studente'];
    
    $query = "UPDATE  `studente` SET  `AutorizzazioneRegistro` =  '$permesso' WHERE  `studente`.`id_studente` =$idstudente;";
    
    if($conn->query($query))
        echo "ok";