<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $username = $connection->escape_string($_POST['username']);
    $psw = ($_POST['password']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $citta = $connection->escape_string($_POST['citta']);
    $mail = (isset($_POST['mail'])) ? $connection->escape_string($_POST['mail']) : "";
    $classe = $_POST['classe'];
    $telefono = $connection->escape_string($_POST['telefono']);
    $scuola = $_POST['scuola']; 
    $annoscolastico = $_POST['annoclasse'];
        
    $connection->query("SET FOREIGN_KEY_CHECKS=0");
    $userquery = "INSERT INTO utente (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', 6)";


    $Query = "INSERT INTO `studente` (`id_studente`, `nome`, `cognome`, `citta`, `email`, `telefono`, `scuola_id_scuola`) "
            . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 6), '$nome', '$cognome', '$citta', '$mail', '$telefono', $scuola);";

    $classquery = "INSERT INTO `studente_attends_classe` (`studente_id_studente`, `classe_id_classe`, `anno_scolastico_id_anno_scolastico`) VALUES ((SELECT MAX(`id_utente`) FROM `utente` WHERE `tipo_utente` = 6), $classe, $annoscolastico)";

    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    if ($connection->query($userquery) && $connection->query($Query) && $connection->query($classquery))
        echo "ok";
    else
        echo $connection->error;