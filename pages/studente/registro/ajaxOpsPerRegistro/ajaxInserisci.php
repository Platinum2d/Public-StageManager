<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $data = $_POST['data'];
    $descrizione = $conn->escape_string($_POST['descrizione']);
    $idstudente = $_SESSION['userId'];
    
    $query = "INSERT INTO `lavoro_giornaliero` (data,descrizione,studente_id_studente) VALUES ('$data','$descrizione',$idstudente)";
    
    if($conn->query($query))
    {
        $query = "SELECT MAX(id_lavoro_giornaliero) FROM lavoro_giornaliero";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        echo $row['MAX(id_lavoro_giornaliero)'];
    }
    