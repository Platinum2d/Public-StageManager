<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    $idazienda = $_POST['id'];
    $username = $conn->escape_string($_POST['username']);
    $password = $_POST['password'];
    $nomeazienda = $conn->escape_string($_POST['nomeazienda']);
    $cittaazienda = $conn->escape_string($_POST['cittaazienda']);
    $capazienda = $_POST['capazienda'];
    $indirizzoazienda = $conn->escape_string($_POST['indirizzoazienda']);
    $telefonoazienda = $conn->escape_string($_POST['telefonoazienda']);
    $email = $conn->escape_string($_POST['email']);
    $sitoweb = $conn->escape_string($_POST['sitoweb']);
    $nomeresponsabile = $conn->escape_string($_POST['nomeresponsabile']);
    $cognomeresponsabile = $conn->escape_string($_POST['cognomeresponsabile']);
    $telefonoreponsabile = $conn->escape_string($_POST['telefonoresponsabile']);
    $emailresponsabile = $conn->escape_string($_POST['emailresponsabile']);
        
    $userquery = "UPDATE  `utente` SET  `username` =  '$username' ";
    if ($password !== "immutato") $userquery .= "`, password` =  '".md5($password)."' ";
    
    $userquery .= "WHERE id_utente = $idazienda";
    
    $ok = ($conn->query($userquery)) ? true : false;    
    $Query = " UPDATE `azienda` SET `nome_aziendale` =  '$nomeazienda', `citta_aziendale` =  '$cittaazienda', `CAP` =  '$capazienda', `indirizzo` =  '$indirizzoazienda', `telefono_aziendale` =  '$telefonoazienda',"
            . " `email_aziendale` =  '$email', `sito_web` =  '$sitoweb', `nome_responsabile` =  '$nomeresponsabile', `cognome_responsabile` =  '$cognomeresponsabile', `telefono_responsabile` =  '$telefonoreponsabile', `email_responsabile` =  '$emailresponsabile' WHERE "
            . "id_azienda = $idazienda";

    $ok = ($conn->query($Query)) ? true : false;   
    
    if ($ok)
        echo "Inserimento dei dati riuscito!";
    else
        echo $conn->error;
    