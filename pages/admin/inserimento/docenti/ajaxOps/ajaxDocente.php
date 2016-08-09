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
    $isSuperUser  =  ($_POST['isSuperUser'] === 'true') ? 1 : 0;
    $isDocenteReferente  =  ($_POST['isDocenteReferente'] === 'true') ? 1 : 0;
    $isDocenteTutor  =  ($_POST['isDocenteTutor'] === 'true') ? 1 : 0;    
    
    $Query = "INSERT INTO `docente` (`username`, `password`, `nome`, `cognome`, `telefono`, `email`, `docente_referente`, `docente_tutor`, `super_user`) "
            . "VALUES ('$username', '$password', '$nome', '$cognome', '$telefono', '$email', '$isDocenteReferente', '$isDocenteTutor', '$isSuperUser');";
    
    if (!$connection->query($Query))
        echo "Inserimento dei dati NON riuscito";
    else
        echo "Inserimento dei dati riuscito!";
    

