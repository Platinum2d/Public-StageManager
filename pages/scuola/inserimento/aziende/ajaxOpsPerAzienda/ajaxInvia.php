<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $citta = $connection->escape_string($_POST['citta']);
    $CAP = $_POST['CAP'];
    $indirizzo = $connection->escape_string($_POST['indirizzo']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    $sito = $connection->escape_string($_POST['sito']);
    $nomeresponsabile = $connection->escape_string($_POST['nomeresponsabile']);
    $cognomeresponsabile = $connection->escape_string($_POST['cognomeresponsabile']);
    $telefonoresponsabile = $connection->escape_string($_POST['telefonoresponsabile']);
    $emailresponsabile = $connection->escape_string($_POST['emailresponsabile']);
    
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    $ok = false;
    
    $queryusers = "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', ".ceoType.")";
    $ok = (!$connection->query($queryusers)) ? false : true;
    
    $Query = "INSERT INTO `azienda` (`id_azienda`, `nome_aziendale`, `citta_aziendale`, `CAP`, `indirizzo`, `telefono_aziendale`, `email_aziendale`, `sito_web`, `nome_responsabile`, `cognome_responsabile`, `telefono_responsabile`, `email_responsabile`) "
            . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 4), '$nome'";
            if ($citta != "") {
                $Query .= ", '$citta'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($CAP != "") {
                $Query .= ", '$CAP'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($indirizzo != "") {
                $Query .= ", '$indirizzo'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($telefono != "") {
                $Query .= ", '$telefono'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($citta != "") {
                $Query .= ", '$email'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($CAP != "") {
                $Query .= ", '$sito'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($indirizzo != "") {
                $Query .= ", '$nomeresponsabile'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($telefono != "") {
                $Query .= ", '$cognomeresponsabile'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($indirizzo != "") {
                $Query .= ", '$telefonoresponsabile'";
            }
            else {
                $Query .= ", NULL";
            }
            if ($telefono != "") {
                $Query .= ", '$emailresponsabile'";
            }
            else {
                $Query .= ", NULL";
            }
            $Query .= ");";
    
    $ok = (!$connection->query($Query)) ? false : true;
    
    if ($ok) echo "Inserimento dei dati riuscito!"; else echo "non ok";
    $connection->query("SET FOREIGN_KEY_CHECKS = 1");
?>