<?php

    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idstudente = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "SELECT `id_studente` FROM `studente`, `utente` WHERE `id_studente` = $idstudente AND `id_utente` = $idstudente AND `password` = '$password'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0)
        echo "non esiste";
    else
        echo "esiste";