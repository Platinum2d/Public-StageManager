<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    $azienda = $connection->escape_string($_POST['azienda']);
    
    $userquery = "INSERT INTO utente (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', ".aztutType.")";
    $ok = ($connection->query($userquery)) ? true : false;
    
    $Query = "INSERT INTO `tutor` (`id_tutor`, `nome`, `cognome`, `telefono`, `email`, `azienda_id_azienda`) "
            . "VALUES ( (SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 5), '$nome', '$cognome', '$telefono', '$email', $azienda)";
    
    $ok = ($connection->query($Query)) ? true : false;
    
    if (!$ok)
        echo "Inserimento dati NON riuscito";
    else
        echo "Inserimento dei dati riuscito!";
?>