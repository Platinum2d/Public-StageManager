<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idstudente = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "SELECT studente.id_studente 
                FROM studente, utente 
                WHERE studente.id_studente = $idstudente  
                AND utente.id_utente = studente.id_studente
                AND password = '$password'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0)
        echo "non esiste";
    else
        echo "esiste";
?>