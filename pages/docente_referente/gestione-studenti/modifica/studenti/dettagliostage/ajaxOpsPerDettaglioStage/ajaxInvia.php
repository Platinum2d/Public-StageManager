<?php
    include '../../../../../../functions.php';
    $connection = dbConnection("../../../../../../../");
    
    $azienda = (!isset($_POST['azienda']) || empty($_POST['azienda']) || $_POST['azienda'] === "-1") ? "NULL" : $_POST['azienda'];
    $tutor = (!isset($_POST['tutor']) || empty($_POST['tutor']) || $_POST['tutor'] === "-1") ? "NULL" : $_POST['tutor'];
    $docente = (!isset($_POST['docente']) || empty($_POST['docente']) || $_POST['docente'] === "-1") ? "NULL" : $_POST['docente'];
    $studente = $_POST['studente'];
    $classe_has_stage = $_POST['classe_has_stage'];
    $studente_has_stage = $_POST['studente_has_stage'];
    $autorizzazione = ($_POST['autorizzazione'] === "true") ? "1" : "0";
    $visita = ($_POST['visita'] === "true") ? "1" : "0";
    
    if (!isset($studente_has_stage) || empty($studente_has_stage) || $studente_has_stage === "-1")
    {
        $query = "INSERT INTO studente_has_stage "
                . "(azienda_id_azienda, tutor_id_tutor, docente_tutor_id_docente_tutor, studente_id_studente, classe_has_stage_id_classe_has_stage, autorizzazione_registro, visita_azienda) "
                . "VALUES ($azienda, $tutor, $docente, $studente, $classe_has_stage, $autorizzazione, '$visita')";
    }
    else
    {
        $query = "UPDATE studente_has_stage "
                . "SET azienda_id_azienda = $azienda, tutor_id_tutor = $tutor, docente_tutor_id_docente_tutor = $docente, autorizzazione_registro = $autorizzazione, visita_azienda = '$visita' "
                . "WHERE id_studente_has_stage = $studente_has_stage";
    }
    
    if ($connection->query($query))
    {
        echo "ok";
    }
    else
    {
        echo $connection->error;
    }