<?php

    include "../../../../../functions.php";
    $conn = dbConnection("../../../../../../");
    
    $nome = $conn->escape_string($_POST['nome']);
    $descrizione = $conn->escape_string($_POST['descrizione']);
    $id = $_POST['id'];
    
    $query = "UPDATE modulo_valutazione_studente SET nome = '$nome', descrizione = '$descrizione' WHERE id_modulo_valutazione_studente = $id";
    
    if ($conn->query($query))
        echo "ok";
    else
        $conn->error;