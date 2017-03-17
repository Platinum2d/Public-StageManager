<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    $ok = false;
    $queryusers = "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', ".docrefType.")";
    
    $Query = "INSERT INTO `docente` (`id_docente`,  `nome`, `cognome`, `telefono`, `email`) "
        . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".docrefType."), '$nome', '$cognome', '$telefono', '$email');";
    $ok = (!$connection->query($queryusers)) ? false : true;
    $ok = (!$connection->query($Query)) ? false : true;
    
    if (!$ok)
        echo $connection->error;
    else
        echo "Inserimento dei dati riuscito!";
?>