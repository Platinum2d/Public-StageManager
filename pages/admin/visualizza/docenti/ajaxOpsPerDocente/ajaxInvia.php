<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $iddocente = $_POST['id'];
    $username = $conn->escape_string($_POST['username']);
    $password = $_POST['password'];
    $cognome = $conn->escape_string($_POST['cognome']);
    $nome = $conn->escape_string($_POST['nome']);
    $telefono = $conn->escape_string($_POST['telefono']);
    $email = $conn->escape_string($_POST['email']);
    $docentetutor = $_POST['docente_tutor'];
    $docentereferente = $_POST['docente_referente'];
    
    $query = "UPDATE  `utente` SET  `username` =  '$username' ";
    if ($password !== "immutato") $query .= ", `password` =  '".md5($password)."'";
    
    $query .= " WHERE id_utente = $iddocente";
    
    $ok = ($conn->query($query)) ? true : false;
    
    $query = "UPDATE `docente` SET `nome` =  '$nome',`cognome` =  '$cognome',`telefono` =  '$telefono',`email` =  '$email', `docente_referente` =  '$docentereferente',"
            . "`docente_tutor` =  '$docentetutor' WHERE  `id_docente` = $iddocente;";
    
    $ok = ($conn->query($query)) ? true : false;
    
    if ($ok)
        echo "ok";
    else 
        echo "non ok";
    
    
    
    
    