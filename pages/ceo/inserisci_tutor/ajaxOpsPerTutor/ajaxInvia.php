<?php

    include '../../../functions.php';
    $connection = dbConnection("../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    
    $Query = "INSERT INTO `tutor` (`username`, `password`, `nome`, `cognome`, `telefono`, `email`, `azienda_id_azienda`) "
            . "VALUES ('$username', '$password', '$nome', '$cognome', '$telefono', '$email', ".$_SESSION['userId'].")";
    
    
    
    if (!$connection->query($Query))
        echo "Inserimento dati NON riuscito";
    else
        echo "Inserimento dei dati riuscito!";
    
    

