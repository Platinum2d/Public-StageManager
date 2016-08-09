<?php

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $citta = $connection->escape_string($_POST['citta']);
    $CAP = $_POST['CAP'];
    $indirizzo = $connection->escape_string($_POST['indirizzo']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    $sito = $connection->escape_string($_POST['sito']);
    $nomeresponsabile = $connection->escape_string($_POST['nomeresponsabile']);
    $cognomeresponsabile = $connection->escape_string($_POST['cognomeresponsabile']);
    $telefonoresponsabile = $connection->escape_string($_POST['telefonoresponsabile']);
    $emailresponsabile = $connection->escape_string($_POST['emailresponsabile']);
    
    $Query = "INSERT INTO `azienda` (`username`, `password`, `nome_aziendale`, `citta_aziendale`, `CAP`, `indirizzo`, `telefono_aziendale`, `email_aziendale`, `sito_web`, `nome_responsabile`, `cognome_responsabile`, `telefono_responsabile`, `email_responsabile`) "
            . "VALUES ('$username', '$password', '$nome', '$citta', '$CAP', '$indirizzo', '$telefono', '$email', '$sito', '$nomeresponsabile', '$cognomeresponsabile', '$telefonoresponsabile', '$emailresponsabile');";
    
    
    if(!$connection->query($Query))
        echo "Inserimento dei dati NON riuscito";
    else
        echo "Inserimento dei dati riuscito!";
    

