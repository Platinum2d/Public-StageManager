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
        $nome = (empty($_POST['nome']) || !isset($_POST['nome'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['nome'])))."'";
        $citta = (empty($_POST['citta']) || !isset($_POST['citta'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['citta'])))."'";
        $CAP = (empty($_POST['CAP']) || !isset($_POST['CAP'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['CAP'])))."'";
        $indirizzo = (empty($_POST['indirizzo']) || !isset($_POST['indirizzo'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['indirizzo'])))."'";
        $telefono = (empty($_POST['telefono']) || !isset($_POST['telefono'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['telefono'])))."'";
        $email = (empty($_POST['email']) || !isset($_POST['email'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['email'])))."'";
        $sitoweb = (empty($_POST['sitoweb']) || !isset($_POST['sitoweb'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['sitoweb'])))."'";
        
        $nomeresponsabile = (empty($_POST['nomeresp']) || !isset($_POST['nomeresp'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['nomeresp'])))."'";
        $cognomeresponsabile = (empty($_POST['cognomeresp']) || !isset($_POST['cognomeresp'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['cognomeresp'])))."'";
        $telefonoresponsabile = (empty($_POST['telefonoresp']) || !isset($_POST['telefonoresp'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['telefonoresp'])))."'";
        $mailresponsabile = (empty($_POST['mailresp']) || !isset($_POST['mailresp'])) ? "NULL" : "'".strip_tags(trim($connessione->escape_string($_POST['mailresp'])))."'";

        $query = "UPDATE scuola SET nome = $nome, citta = $citta, CAP = $CAP, indirizzo = $indirizzo, telefono = $telefono, email = $email, sito_web = $sitoweb, "
                . "nome_responsabile = $nomeresponsabile, cognome_responsabile = $cognomeresponsabile, telefono_responsabile = $telefonoresponsabile, email_responsabile = $mailresponsabile "
                . "WHERE id_scuola = $id";

        if ($connessione->query($query))
            echo "ok";
        else 
            echo $connessione->error;
    }
    else
        echo $connessione->error;