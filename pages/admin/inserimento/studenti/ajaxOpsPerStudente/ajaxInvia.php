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
    
    if ($_POST['azienda'] === "")
    {
        $azienda = "-1";
    }
    else
    {
        if($result = $connection->query("SELECT id_azienda FROM azienda WHERE nome_aziendale = '".$_POST['azienda']."'"))
        {
            $row = $result->fetch_assoc();
            $azienda = $row['id_azienda'];
        }
        else 
            $azienda = "-1";
    }
        
    if ($_POST['docente'] === "")
    {
        $docente = "-1";
    }
    else
    {
        $docenteEsploso = explode(" ", $_POST['docente']);
        $nomeDocente = $docenteEsploso[0]; $cognomeDocente = $docenteEsploso[1];
        $qu = "SELECT id_docente FROM docente WHERE cognome = '$nomeDocente' AND nome = '$cognomeDocente'";
            
        if($result = $connection->query($qu))
        {
            $row = $result->fetch_assoc();
            $docente = $row['id_docente'];
        }
        else 
            $docente = "-1";
    }
        
    if ($_POST['tutor'] === "" || $_POST['tutor'] === 'selezionare una azienda....')
    {
        $tutor = "-1";
    }
    else
    {
        $tutorEsploso = explode(" ", $_POST['tutor']);
        $nomeTutor = $tutorEsploso[0]; $cognomeTutor = $tutorEsploso[1];
        $qu = "SELECT id_tutor FROM tutor WHERE cognome = '$nomeTutor' AND nome = '$cognomeTutor'";
            
        if($result = $connection->query($qu))
        {
            $row = $result->fetch_assoc();
            $tutor = $row['id_tutor'];
        }
        else 
            $tutor = "-1";       
    }
        
        $connection->query("SET FOREIGN_KEY_CHECKS=0");
        $userquery = "INSERT INTO utente (`username`, `password`, `tipo_utente`) VALUES ('$username', '$password', 6)";
        
            
        $Query = "INSERT INTO `studente` (`id_studente`, `nome`, `cognome`, `citta`, `email`, `telefono`, `visita_azienda`, `scuola_id_scuola`, `azienda_id_azienda`, `docente_id_docente`, `tutor_id_tutor`, `valutazione_studente_id_valutazione_studente`, `valutazione_stage_id_valutazione_stage`) "
                . "VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 6), '$nome', '$cognome', '$citta', '$mail', '$telefono', 0, $scuola, $azienda, $docente, $tutor, -1, -1);";
                    
        $classquery = "INSERT INTO studente_attends_classe (studente_id_studente, classe_id_classe, anno_scolastico_id_anno_scolastico) VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 6), $classe, $annoscolastico)";
       
        $connection->query("SET FOREIGN_KEY_CHECKS = 0");
        if ($connection->query($userquery) && $connection->query($Query) && $connection->query($classquery))
            echo "ok";
?>