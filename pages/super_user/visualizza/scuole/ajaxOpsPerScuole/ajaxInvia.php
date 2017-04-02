<?php
    include '../../../../functions.php';
    
    $connessione = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    
    $username = strip_tags(trim($connessione->escape_string($_POST['username'])));
    $password = $_POST['password'];
    
    $userquery = "UPDATE utente SET username = '$username' ";
    if ($password !== "immutato") $userquery .= ", password =  '".md5($password)."'";
    $userquery .= " WHERE id_utente = $id";
    
    if ($connessione->query($userquery))
    {    
        $nome = (empty($_POST['nome']) || !isset($_POST['nome'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['nome'])));
        $citta = (empty($_POST['citta']) || !isset($_POST['citta'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['citta'])));
        $CAP = (empty($_POST['CAP']) || !isset($_POST['CAP'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['CAP'])));
        $indirizzo = (empty($_POST['indirizzo']) || !isset($_POST['indirizzo'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['indirizzo'])));
        $telefono = (empty($_POST['telefono']) || !isset($_POST['telefono'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['telefono'])));
        $email = (empty($_POST['email']) || !isset($_POST['email'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['email'])));
        $sitoweb = (empty($_POST['sitoweb']) || !isset($_POST['sitoweb'])) ? "NULL" : strip_tags(trim($connessione->escape_string($_POST['sitoweb'])));

        $query = "UPDATE scuola SET ";
        if ($nome !== "NULL") $query .= "nome = '$nome', "; else $query .= "nome = $nome, ";
        if ($citta !== "NULL") $query .= "citta = '$citta', "; else $query .= "citta = $citta, ";
        if ($CAP !== "NULL") $query .= "CAP = '$CAP', "; else $query .= "CAP = $CAP, ";
        if ($indirizzo !== "NULL") $query .= "indirizzo = '$indirizzo', "; else $query .= "indirizzo = $indirizzo, ";
        if ($telefono !== "NULL") $query .= "telefono = '$telefono', "; else $query .= "telefono = $telefono, ";
        if ($email !== "NULL") $query .= "email = '$email', "; else $query .= "email = $email, ";
        if ($sitoweb !== "NULL") $query .= "sito_web = '$sitoweb' "; else $query .= "sito_web = $sitoweb ";   

        $query .= " WHERE id_scuola = $id";

        if ($connessione->query($query))
            echo "ok";
        else 
            echo $connessione->error;
    }
    else
        echo $connessione->error;