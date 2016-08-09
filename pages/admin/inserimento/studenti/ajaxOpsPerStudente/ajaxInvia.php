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
    $telefono = $connection->escape_string($_POST['telefono']);
    $iniziostage = $_POST['iniziostage'];    
    $duratastage = ($_POST['duratastage'] === '') ? "NULL" : $_POST['duratastage'];      
    $finestage = date("Y-m-d",strtotime("+".$duratastage." days", strtotime($iniziostage)));   
   
    
    if ($_POST['classe'] === "")
    {
        $classe = "NULL";
    }
    else
    {
        if($result = $connection->query("SELECT id_classe FROM classe WHERE nome = '".$_POST['classe']."'"))
        {
            $row = $result->fetch_assoc();
            $classe = $row['id_classe'];
        }
        else 
            $classe = "NULL";
    }
    
    if ($_POST['azienda'] === "")
    {
        $azienda = "NULL";
    }
    else
    {
        if($result = $connection->query("SELECT id_azienda FROM azienda WHERE nome_aziendale = '".$_POST['azienda']."'"))
        {
            $row = $result->fetch_assoc();
            $azienda = $row['id_azienda'];
        }
        else 
            $azienda = "NULL";
    }
    
    if ($_POST['docente'] === "")
    {
        $docente = "NULL";
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
            $docente = "NULL";
    }
    
    if ($_POST['tutor'] === "" || $_POST['tutor'] === 'selezionare una azienda....')
    {
        $tutor = "NULL";
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
            $tutor = "NULL";       
    }    
    
        $Query = "INSERT INTO `studente` (`username`, `password`, `nome`, `cognome`, `citta`, `email`, `telefono`, `inizio_stage`, `durata_stage`, `visita_azienda`, `classe_id_classe`, `azienda_id_azienda`, `docente_id_docente`, `tutor_id_tutor`, `valutazione_studente_id_valutazione_studente`, `valutazione_stage_id_valutazione_stage`) "
                . "VALUES ('$username', '$password', '$nome', '$cognome', '$citta', '$mail', '$telefono', $iniziostage, $duratastage, 0, $classe, $azienda, $docente, $tutor, NULL, NULL);";
        
        if(!$connection->query($Query))
        {   
            if(!$connection->query("SET FOREIGN_KEY_CHECKS=0"))
            {
                echo "inserimento dei dati NON riuscito";
                $connection->query("SET FOREIGN_KEY_CHECKS=1");
            }
            else 
            {
                if(!$connection->query($Query))
                {
                    echo "inserimento dei dati NON riuscito";
                    $connection->query("SET FOREIGN_KEY_CHECKS=1");
                }
                else
                {
                    echo "Inserimento dei dati riuscito!";
                    $connection->query("SET FOREIGN_KEY_CHECKS=1");
                }
            }            
        }
        else
        {
            
            $headers = "From:" . $cognome . " " . $nome . "<" . $mail .">";
            $messaggio = "Il tuo username e' : $username, la tua password e' : $psw";
            $object = "credenziali di acccesso";
            
            stripslashes ( $messaggio );
            stripslashes ( $object );
            
            if (mail($mail, $object, $messaggio, $headers)) 
            {
                echo "Inserimento dei dati riuscito! (mail inviata)"; 
            }
            else
            {
                echo "Inserimento dei dati riuscito! (mail non inviata)";
            }
            $connection->query("SET FOREIGN_KEY_CHECKS=1");
        }