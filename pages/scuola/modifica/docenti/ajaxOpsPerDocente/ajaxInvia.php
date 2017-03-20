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
    $tipo_utente = $_POST['tipo_utente'];
    
    
    $query = "UPDATE  `utente` SET  `username` =  '$username', `tipo_utente` = '$tipo_utente' ";
    if ($password !== "immutato") $query .= ", `password` =  '".md5($password)."'";
    
    $query .= " WHERE id_utente = $iddocente";
    
    $ok = ($conn->query($query)) ? true : false;
    
    $query = "UPDATE `docente` SET `nome` =  '$nome',`cognome` =  '$cognome',`telefono` =  '$telefono',`email` =  '$email' WHERE  `id_docente` = $iddocente;";
    
    $ok = ($conn->query($query)) ? true : false;
    
    if ($ok)
        echo "ok";
    else 
        echo "non ok";
?>