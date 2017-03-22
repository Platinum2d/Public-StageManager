<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $username = $connection->escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $telefono = $connection->escape_string($_POST['telefono']);
    $email = $connection->escape_string($_POST['email']);
    $type = ($_POST['docente_tutor'] === '0') ? docrefType : doctutType;
    $classe = $_POST['classe'];
    $anno = $idanno = $connection->query("SELECT * FROM anno_scolastico WHERE corrente = 1")->fetch_assoc()['id_anno_scolastico'];
    
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    $ok = false;
    $queryusers = "INSERT INTO `utente` (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', $type)";
    
    $Query = "INSERT INTO `docente` (`id_docente`,  `nome`, `cognome`, `telefono`, `email`) "
        . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".$type."), '$nome', '$cognome', '$telefono', '$email');";
    
    $chdquery = "INSERT INTO `classe_has_docente` (`docente_id_docente`, `classe_id_classe`, `anno_scolastico_id_anno_scolastico`) "
            . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".$type."), $classe, $anno)";
    
    $ok = (!$connection->query($queryusers)) ? false : true;
    $ok = (!$connection->query($Query)) ? false : true;
    $ok = (!$connection->query($chdquery)) ? false : true;
    
    if (!$ok)
        echo $connection->error;
    else
        echo "Inserimento dei dati riuscito!";
?>