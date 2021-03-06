<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username =  $connection->escape_string(strip_whitespaces($_POST['username']));
    $password = md5($_POST['password']);
    $nome =  $connection->escape_string($_POST['nome']);
    $cognome =  $connection->escape_string($_POST['cognome']);
    $telefono =  $connection->escape_string($_POST['telefono']);
    $email =  $connection->escape_string($_POST['email']);
    $isDocenteReferente  =  ($_POST['isDocenteReferente'] === 'true') ? 1 : 0;
    $isDocenteTutor  =  ($_POST['isDocenteTutor'] === 'true') ? 1 : 0;    
    $scuola = $_POST['scuola'];
    
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    $ok = false;
    $type;
    if ($isDocenteTutor) {
        $type = doctutType; 
    }
    else {
        $type = docrefType;        
    }    
    $queryusers = "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', $type)";
    
    $Query = "INSERT INTO `docente` (`id_docente`, `nome`, `cognome`, `telefono`, `email`, `scuola_id_scuola`) "
        . "VALUES ( (SELECT MAX(id_utente) FROM utente WHERE tipo_utente = $type), '$nome', '$cognome'";

    if ($telefono != "") {
        $Query .= ",'$telefono'";
    }
    else {
        $Query .= ",NULL";
    }
    if ($email != "") {
        $Query .= ",'$email'";
    }
    else {
        $Query .= ",NULL";
    }
    $Query .= ", $scuola);";
    
    $ok = (!$connection->query($queryusers)) ? false : true;
    $ok = (!$connection->query($Query)) ? false : true;
    
    if (!$ok)
        echo $connection->error;
    else
        echo "Inserimento dei dati riuscito!";
?>