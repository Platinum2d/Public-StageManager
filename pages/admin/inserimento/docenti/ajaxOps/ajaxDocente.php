<?php
//    include 'functions.php';
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username =  $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome =  $connection->escape_string($_POST['nome']);
    $cognome =  $connection->escape_string($_POST['cognome']);
    $telefono =  $connection->escape_string($_POST['telefono']);
    $email =  $connection->escape_string($_POST['email']);
    $isDocenteReferente  =  ($_POST['isDocenteReferente'] === 'true') ? 1 : 0;
    $isDocenteTutor  =  ($_POST['isDocenteTutor'] === 'true') ? 1 : 0;    
    
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    $ok = false;
    $queryusers = ($isDocenteTutor) ? "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', 3)" : "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', 2)";
    
    $Query = ($isDocenteTutor) ? "INSERT INTO `docente` (`id_docente`, `nome`, `cognome`, `telefono`, `email`, `docente_referente`, `docente_tutor`) "
        . "VALUES ( (SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 3), '$nome', '$cognome', '$telefono', '$email', '$isDocenteReferente', '$isDocenteTutor');"
            : "INSERT INTO `docente` (id_docente,  `nome`, `cognome`, `telefono`, `email`, `docente_referente`, `docente_tutor`) "
        . "VALUES ( (SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 2), '$nome', '$cognome', '$telefono', '$email', '$isDocenteReferente', '$isDocenteTutor');";
    $ok = (!$connection->query($queryusers)) ? false : true;
    $ok = (!$connection->query($Query)) ? false : true;
    
    if (!$ok)
        echo $connection->error;
    else
        echo "Inserimento dei dati riuscito!";
    

