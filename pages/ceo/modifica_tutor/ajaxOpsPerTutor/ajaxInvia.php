<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    $idtutor = $_POST['id'];
    $username = $conn->escape_string($_POST['username']);
    $nome = $conn->escape_string($_POST['nome']);
    $cognome = $conn->escape_string($_POST['cognome']);
    $mail = $conn->escape_string($_POST['mail']);
    $telefono = $conn->escape_string($_POST['telefono']);
    
    $Query = "UPDATE `tutor` SET `username` = '$username', `nome` = '$nome', `cognome` = '$cognome',  `email` = '$mail', `telefono` = '$telefono' WHERE id_tutor = $idtutor";
    if ($conn->query($Query))
        echo "Inserimento dei dati riuscito!";
    else
        echo "Inserimento dei dati non riuscito!";
    