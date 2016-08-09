<?php

    $recoveredData = file_get_contents('../../db.txt');
    $recoveredArray = unserialize($recoveredData);
    $connessione = new mysqli($recoveredArray['host'],$recoveredArray['user'],$recoveredArray['password'],$recoveredArray['name']);
    
    $username = $connessione->escape_string($_POST['username']);
    $nome = $connessione->escape_string($_POST['nome']);
    $password = md5($_POST['password']);
    $cognome = $connessione->escape_string($_POST['cognome']);
    $mail = $connessione->escape_string($_POST['mail']);
    $telefono = $connessione->escape_string($_POST['telefono']);
    
    if (!$connessione->query("INSERT INTO `docente` (`username`, `password`, `nome`, `cognome`, `telefono`, `email`, `docente_referente`, `docente_tutor`, `super_user`)"
            . " VALUES ('$username', '$password', '$nome', '$cognome', '$telefono', '$mail', '0', '0', '1');")) echo $connessione->error;
    else
    {
        $okuser = fopen("../../okuser.txt","w");
        fclose($okuser);
        echo "ok";
    }