<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    $idtutor = $_POST['id'];
    $password = $_POST['password'];
    $username = $conn->escape_string($_POST['username']);
    $nome = $conn->escape_string($_POST['nome']);
    $cognome = $conn->escape_string($_POST['cognome']);
    $mail = $conn->escape_string($_POST['mail']);
    $telefono = $conn->escape_string($_POST['telefono']);
    $azienda = $_POST['azienda'];
    
    $Query = "UPDATE `tutor` SET `username` = '$username', ";
    if ($password !== "immutato") $Query .= "`password` = '".md5($password)."', ";
    $Query .= "`nome` = '$nome', `cognome` = '$cognome',  `email` = '$mail', `telefono` = '$telefono', `azienda_id_azienda` = $azienda  WHERE id_tutor = $idtutor";
    if ($conn->query($Query))
        echo "Inserimento dei dati riuscito!";
    else
        echo "Inserimento dei dati non riuscito!";
    