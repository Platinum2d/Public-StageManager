<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    
    $userquery = "INSERT INTO utente (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', ".aztutType.")";
    
    $Query = "INSERT INTO `tutor` (`id_tutor`, `nome`, `cognome`, `telefono`, `email`, `azienda_id_azienda`) "
            . "VALUES ((SELECT MAX(id_utente) FROM utente),'$nome', '$cognome'";
    if ($telefono != "") {
        $Query .= ", '$telefono'";
    }
    else {
        $Query .= ", NULL";
    }
    if ($email != "") {
        $Query .= ", '$email'";
    }
    else {
        $Query .= ", NULL";
    }
    $Query .= ", ".$_SESSION['userId'].");";
    
    if (!$connection->query("SET FOREIGN_KEY_CHECKS = 0") || !$connection->query($userquery) || !$connection->query($Query))
        echo $connection->error;
    else
        echo "Inserimento dei dati riuscito!";
?>