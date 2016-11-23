<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    $idaz = $_SESSION['userId'];
    $idspec = $_POST['id'];
    
    $query = "INSERT INTO `azienda_has_specializzazione` (`azienda_id_azienda`,`specializzazione_id_specializzazione`) VALUES ($idaz,$idspec)";
    if($conn->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $conn->error;
    }
?>