<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    $idazienda = $_POST['id'];
    $username = $conn->escape_string(strip_whitespaces($_POST['username']));
    $password = $_POST['password'];
    $nomeazienda = $conn->escape_string($_POST['nomeazienda']);
    
    $cittaazienda = $conn->escape_string($_POST['cittaazienda']);
    $cittaazienda = (isset($cittaazienda) && !empty($cittaazienda)) ? "'$cittaazienda'" : 'NULL';
    
    $capazienda = $_POST['capazienda'];
    $capazienda = (isset($capazienda) && !empty($capazienda)) ? "'$capazienda'" : 'NULL';
    
    $indirizzoazienda = $conn->escape_string($_POST['indirizzoazienda']);
    $indirizzoazienda = (isset($indirizzoazienda) && !empty($indirizzoazienda)) ? "'$indirizzoazienda'" : 'NULL';
    
    $telefonoazienda = $conn->escape_string($_POST['telefonoazienda']);
    $telefonoazienda = (isset($telefonoazienda) && !empty($telefonoazienda)) ? "'$telefonoazienda'" : 'NULL';
    
    $email = $conn->escape_string($_POST['email']);
    $email = (isset($email) && !empty($email)) ? "'$email'" : 'NULL';
    
    $sitoweb = $conn->escape_string($_POST['sitoweb']);
    $sitoweb = (isset($sitoweb) && !empty($sitoweb)) ? "'$sitoweb'" : 'NULL';
    
    $nomeresponsabile = $conn->escape_string($_POST['nomeresponsabile']);
    $nomeresponsabile = (isset($nomeresponsabile) && !empty($nomeresponsabile)) ? "'$nomeresponsabile'" : 'NULL';
    
    $cognomeresponsabile = $conn->escape_string($_POST['cognomeresponsabile']);
    $cognomeresponsabile = (isset($cognomeresponsabile) && !empty($cognomeresponsabile)) ? "'$cognomeresponsabile'" : 'NULL';
    
    $telefonoreponsabile = $conn->escape_string($_POST['telefonoresponsabile']);
    $telefonoreponsabile = (isset($telefonoreponsabile) && !empty($telefonoreponsabile)) ? "'$telefonoreponsabile'" : 'NULL';
    
    $emailresponsabile = $conn->escape_string($_POST['emailresponsabile']);
    $emailresponsabile = (isset($emailresponsabile) && !empty($emailresponsabile)) ? "'$emailresponsabile'" : 'NULL';
        
    $userquery = "UPDATE  `utente` SET  `username` =  '$username' ";
    if ($password !== "immutato") $userquery .= ", `password` =  '".md5($password)."' ";
    
    $userquery .= "WHERE `id_utente` = $idazienda";
    
    $ok = ($conn->query($userquery)) ? true : false;    
    $Query = " UPDATE `azienda` SET `nome_aziendale` =  '$nomeazienda', `citta_aziendale` =  $cittaazienda, `CAP` =  $capazienda, `indirizzo` =  $indirizzoazienda, `telefono_aziendale` =  $telefonoazienda,"
            . " `email_aziendale` =  $email, `sito_web` =  $sitoweb, `nome_responsabile` =  $nomeresponsabile, `cognome_responsabile` =  $cognomeresponsabile, `telefono_responsabile` =  $telefonoreponsabile, `email_responsabile` =  $emailresponsabile WHERE "
            . "id_azienda = $idazienda";

    $ok = ($conn->query($Query)) ? true : false;   
    
    if ($ok)
        echo "Inserimento dei dati riuscito!";
    else
        echo $conn->error;
?>