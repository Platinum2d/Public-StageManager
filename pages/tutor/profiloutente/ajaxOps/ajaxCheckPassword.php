<?php

    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idtutor = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "SELECT tutor.id_tutor 
    			FROM tutor, utente 
    			WHERE utente.id_utente = $idtutor 
    			AND utente.id_utente = tutor.id_tutor 
    			AND `password` = '$password'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0)
        echo "non esiste";
    else
        echo "esiste";