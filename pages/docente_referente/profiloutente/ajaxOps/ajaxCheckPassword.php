<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idtutor = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "SELECT utente.id_utente 
    			FROM utente 
    			WHERE utente.id_utente = $idtutor 
    			AND `password` = '$password'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0)
        echo "non esiste";
    else
        echo "esiste";
?>