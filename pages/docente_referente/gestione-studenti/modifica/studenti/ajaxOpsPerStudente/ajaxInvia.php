<?php
    $xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\" ?> <data></data>";
    include '../../../../../functions.php';
    $xml = new SimpleXMLElement ( $xmlstr ); 

    $connessione = dbConnection("../../../../../../");
    $id = $_POST['id'];
    $username = $connessione->escape_string(strip_whitespaces($_POST['username']));
    $password = $_POST['password'];
    $nome = $connessione->escape_string($_POST['nome']);
    $cognome = $connessione->escape_string($_POST['cognome']);
    
    $citta = $connessione->escape_string($_POST['citta']);
    $citta = (isset($citta) && !empty($citta)) ? "'$citta'" : "NULL";
    
    $mail = $connessione->escape_string($_POST['mail']);
    $mail = (isset($mail) && !empty($mail)) ? "'$mail'" : "NULL";
    
    $telefono = $connessione->escape_string($_POST['telefono']);
    $telefono = (isset($telefono) && !empty($telefono)) ? "'$telefono'" : "NULL";

    $userquery = "UPDATE utente SET username = '$username' ";
    if ($password !== "immutato") $userquery .= ", `password` = '".md5($password)."' ";
    $userquery .= "WHERE id_utente = $id";

    $Query = "UPDATE `studente` SET `nome` = '$nome', `cognome` = '$cognome', `citta` = $citta, `email` = $mail, `telefono` = $telefono WHERE `id_studente` = $id";

    $connessione->query("SET FOREIGN_KEY_CONTROLS = 0");
    if ($connessione->query($userquery) && $connessione->query($Query))
    {
        $xml->addChild('user',$username);
        $xml->addChild('nome',$nome);
        $xml->addChild('cognome',$cognome);
        $xml->addChild('query',$userquery);
        echo $xml->asXML();
    }
    else
        echo $connessione->error;
    $connessione->query("SET FOREIGN_KEY_CONTROLS = 1");
    ?>