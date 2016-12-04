<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    $idtutor = $_POST['id'];
    $password = $_POST['password'];
    $username = $conn->escape_string($_POST['username']);
    $nome = $conn->escape_string($_POST['nome']);
    $cognome = $conn->escape_string($_POST['cognome']);
    $mail = $conn->escape_string($_POST['mail']);
    $telefono = $conn->escape_string($_POST['telefono']);
    
    $userquery = "UPDATE `utente` SET `username` = '$username' ";
    if ($password !== "immutato") $userquery .= ", `password` = '".md5($password)."' ";
    $userquery .= " WHERE `id_utente` = $idtutor";
    
    $Query = "UPDATE `tutor` SET `nome` = '$nome', `cognome` = '$cognome',  `email` = '$mail', `telefono` = '$telefono' WHERE id_tutor = $idtutor";
    
    if ($conn->query($userquery) && $conn->query($Query))
        echo "Inserimento dei dati riuscito!";
    else
        echo $conn->error;
?>