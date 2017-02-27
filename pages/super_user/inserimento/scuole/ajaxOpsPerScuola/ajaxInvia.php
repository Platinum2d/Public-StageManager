<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");

    $username = $connection->escape_string($_POST['username']);
    $password = $_POST['password'];
    $psw = md5($password);
    
    $nome = $connection->escape_string($_POST['nome']);
    $citta = $connection->escape_string($_POST['citta']);
    $CAP = $_POST['CAP'];
    $indirizzo = $connection->escape_string($_POST['indirizzo']);    
    $telefono = $_POST['telefono'];
    $email = $connection->escape_string(strip_tags($_POST['email']));
    $sito = $connection->escape_string($_POST['sito']);
    
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");    
    $usersquery = "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$psw', ".scuolaType.")";
    
    $query = "INSERT INTO `scuola` (`id_scuola`, `nome`, `citta`, `CAP`, `indirizzo`, `telefono`, `email`, `sito_web`) VALUES ((SELECT MAX(`id_utente`) FROM `utente` WHERE `tipo_utente` = 1), '$nome', ";
    $query .= ($citta === "NULL") ? "NULL, " : "'$citta', ";
    $query .= ($CAP === "NULL") ? "NULL, " : "'$CAP', ";
    $query .= ($indirizzo === "NULL") ? "NULL, " : "'$indirizzo', ";
    $query .= ($telefono === "NULL") ? "NULL, " : "'$telefono', ";
    $query .= ($email === "NULL") ? "NULL, " : "'$email', ";
    $query .= ($sito === "NULL") ? "NULL) " : "'$sito') ";
    
    $ok = ($connection->query($usersquery)) ? true : false;
    $ok = ($connection->query($query)) ? true : false;
    if ($ok) echo "ok"; else echo $connection->error;
?>