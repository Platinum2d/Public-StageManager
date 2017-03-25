<?php    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $username = $connection->escape_string($_POST['username']);
    $psw = ($_POST['password']);
    $password = md5($_POST['password']);
    $nome = $connection->escape_string($_POST['nome']);
    $cognome = $connection->escape_string($_POST['cognome']);
    $citta = (isset($_POST['citta']) && $_POST['citta'] != "") ? "'".$connection->escape_string($_POST['citta'])."'" : "NULL";
    $mail = (isset($_POST['mail']) && $_POST['mail'] != "") ? "'".$connection->escape_string($_POST['mail'])."'" : "NULL";
    $telefono = (isset($_POST['telefono']) && $_POST['telefono'] != "") ? "'".$connection->escape_string($_POST['telefono'])."'" : "NULL";
    $classe = $_POST['classe'];
    $scuola = $_POST['scuola']; 
    $annoscolastico = $_POST['annoclasse'];
        
    $connection->query("SET FOREIGN_KEY_CHECKS=0");
    $userquery = "INSERT INTO utente (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', ".studType.")";


    $Query = "INSERT INTO `studente` (`id_studente`, `nome`, `cognome`, `citta`, `email`, `telefono`, `scuola_id_scuola`) "
            . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 6), '$nome', '$cognome', $citta, $mail, $telefono, $scuola);";

    $classquery = "INSERT INTO `studente_attends_classe` (`studente_id_studente`, `classe_id_classe`, `anno_scolastico_id_anno_scolastico`) VALUES ((SELECT MAX(`id_utente`) FROM `utente` WHERE `tipo_utente` = 6), $classe, $annoscolastico)";

    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    if ($connection->query($userquery) && $connection->query($Query) && $connection->query($classquery))
        echo "ok";
    else
        echo $connection->error;
?>