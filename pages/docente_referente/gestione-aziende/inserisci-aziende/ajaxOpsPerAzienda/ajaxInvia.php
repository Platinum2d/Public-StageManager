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
    $ok = (!$result = $connection->query($queryusers)) ? false : true;
    
    $id_utente = $connection->insert_id;
    
    $userquery = "INSERT INTO azienda (id_azienda, nome_aziendale, citta_aziendale, CAP, indirizzo, telefono_aziendale, email_aziendale, sito_web, nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile)"
                                        . " VALUES ($id_utente,'".$nome."'";
    
    $citta = (!isset($citta) || empty($citta)) ? "NULL" : $citta;
    if ($citta === "NULL") $userquery .= ", $citta"; else $userquery .= ", '$citta'";

    $CAP = (!isset($CAP) || empty($CAP)) ? "NULL" : $CAP;
    if ($CAP === "NULL") $userquery .= ", $CAP"; else $userquery .= ", '$CAP'";

    $indirizzo = (!isset($indirizzo) || empty($indirizzo)) ? "NULL" : $indirizzo;
    if ($indirizzo === "NULL") $userquery .= ", $indirizzo"; else $userquery .= ", '$indirizzo'";

    $telefono = (!isset($telefono) || empty($telefono)) ? "NULL" : $telefono;
    if ($telefono === "NULL") $userquery .= ", $telefono"; else $userquery .= ", '$telefono'";

    $email = (!isset($email) || empty($email)) ? "NULL" : $email;
    if ($email === "NULL") $userquery .= ", $email"; else $userquery .= ", '$email'";

    $sito = (!isset($sito) || empty($sito)) ? "NULL" : $sito;
    if ($sito === "NULL") $userquery .= ", $sito"; else $userquery .= ", '$sito'";
        
    $nomeresponsabile = (!isset($nomeresponsabile) || empty($nomeresponsabile)) ? "NULL" : $nomeresponsabile;
    if ($nomeresponsabile === "NULL") $userquery .= ", $nomeresponsabile"; else $userquery .= ", '$nomeresponsabile'";
        
    $cognomeresponsabile = (!isset($cognomeresponsabile) || empty($cognomeresponsabile)) ? "NULL" : $cognomeresponsabile;
    if ($cognomeresponsabile === "NULL") $userquery .= ", $cognomeresponsabile"; else $userquery .= ", '$cognomeresponsabile'";
        
    $telefonoresponsabile = (!isset($telefonoresponsabile) || empty($telefonoresponsabile)) ? "NULL" : $telefonoresponsabile;
    if ($telefonoresponsabile === "NULL") $userquery .= ", $telefonoresponsabile"; else $userquery .= ", '$telefonoresponsabile'";
        
    $mailresponsabile = (!isset($mailresponsabile) || empty($mailresponsabile)) ? "NULL" : $mailresponsabile;
    if ($telefonoresponsabile === "NULL") $userquery .= ", $telefonoresponsabile)"; else $userquery .= ", '$telefonoresponsabile')";
    
    $ok = (!$connection->query($userquery)) ? false : true;
    
    if ($ok) echo "Inserimento dei dati riuscito!"; else echo "non ok";
    $connection->query("SET FOREIGN_KEY_CHECKS = 1");
?>