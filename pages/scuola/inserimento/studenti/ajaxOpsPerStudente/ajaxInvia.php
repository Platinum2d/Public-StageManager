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
    $scuola = $_SESSION['userId'];
    $annoscolastico = $_POST['annoclasse'];
        
    $connection->query("SET FOREIGN_KEY_CHECKS=0");
    $userquery = "INSERT INTO utente (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', ".studType.")";

    $Query = "INSERT INTO `studente` (`id_studente`, `nome`, `cognome`, `citta`, `email`, `telefono`, `scuola_id_scuola`) "
            . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 6), '$nome', '$cognome', $citta, $mail, $telefono, $scuola);";

    $classquery = "INSERT INTO `studente_attends_classe` (`studente_id_studente`, `classe_id_classe`, `anno_scolastico_id_anno_scolastico`) VALUES ((SELECT MAX(`id_utente`) FROM `utente` WHERE `tipo_utente` = ".studType."), $classe, $annoscolastico)";

    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    if ($connection->query($userquery) && $connection->query($Query) && $connection->query($classquery))
    {
        $query = "SELECT id_classe_has_stage FROM classe_has_stage WHERE classe_id_classe = $classe AND anno_scolastico_id_anno_scolastico = $annoscolastico";
        
        $result = $connection->query($query);
        $errore = false;
        if ($result)
        {
            while ($row = $result->fetch_assoc())
            {
                $id_classe_has_stage = $row['id_classe_has_stage'];

                $query = "INSERT INTO studente_has_stage ("
                        . "visita_azienda, autorizzazione_registro, studente_id_studente, "
                        . "classe_has_stage_id_classe_has_stage, valutazione_studente_id_valutazione_studente, "
                        . "valutazione_stage_id_valutazione_stage, azienda_id_azienda, "
                        . "docente_tutor_id_docente_tutor, tutor_id_tutor) "
                        . "VALUES (0, 1, (SELECT MAX(id_studente) FROM studente), "
                        . "$id_classe_has_stage, NULL, "
                        . "NULL, NULL, "
                        . "NULL, NULL)";
                if (!$connection->query($query))
                    $errore = true;
                
                $docsrefquery = "SELECT DISTINCT docente_id_docente 
                                 FROM studente_has_stage AS shs, docente_referente_has_studente_has_stage AS drhshs, classe_has_stage AS chs 
                                 WHERE shs.id_studente_has_stage = drhshs.studente_has_stage_id_studente_has_stage 
                                 AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                                 AND shs.classe_has_stage_id_classe_has_stage = $id_classe_has_stage";

                $docsrefresult = $connection->query($docsrefquery);
                if (is_object($docsrefresult) && $docsrefresult->num_rows > 0)
                {
                    while ($rowdoc = $docsrefresult->fetch_assoc())
                    {
                        $id_doc = $rowdoc['docente_id_docente'];

                        $query = "INSERT INTO docente_referente_has_studente_has_stage (studente_has_stage_id_studente_has_stage, docente_id_docente) "
                                . "VALUES((SELECT MAX(id_studente_has_stage) FROM studente_has_stage), $id_doc)";
                        if (!$connection->query($query))
                            $errore = true;
                    }
                }
            }
        }
        if (!$errore)
            echo "ok";
        else
            echo $connection->error;
    }
    else
        echo $connection->error;
?>