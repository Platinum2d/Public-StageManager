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
    $superuser = $_POST['super_user'];
    $docentetutor = $_POST['docente_tutor'];
    $docentereferente = $_POST['docente_referente'];
    
    $query = "UPDATE  `docente` SET  `username` =  '$username', ";
    if ($password !== "immutato") $query .= "`password` =  '".md5($password)."', ";
    $query .= "`nome` =  '$nome',`cognome` =  '$cognome',`telefono` =  '$telefono',`email` =  '$email',`super_user` =  '$superuser', `docente_referente` =  '$docentereferente',"
            . "`docente_tutor` =  '$docentetutor' WHERE  `id_docente` = $iddocente;";
    
    if ($conn->query($query))
        echo "ok";
    else 
        echo "non ok";
    
    
    
    
    