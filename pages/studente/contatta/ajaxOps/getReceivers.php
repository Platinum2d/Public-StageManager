<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../");

    $id_studente = intval($_SESSION['userId']);
    $id_shs = intval($_SESSION['userId']);
    $tipo = intval ($_POST ['type']);
    
    if ($tipo == scuolaType) {
        $query = "SELECT scuola.nome, scuola.email
                    FROM scuola, studente_attends_classe, anno_scolastico, classe
                    WHERE studente_attends_classe.studente_id_studente = $id_studente
                    AND studente_attends_classe.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND studente_attends_classe.classe_id_classe = classe.id_classe
                    AND classe.scuola_id_scuola = scuola.id_scuola;";
    }
    elseif ($tipo == docrefType) {
        $id_shs = $_SESSION ['studenteHasStageId'];
        $query = "SELECT docente.nome, docente.cognome, docente.email
					FROM docente, docente_referente_has_studente_has_stage
					WHERE docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = $id_shs
					AND docente_referente_has_studente_has_stage.docente_id_docente = docente.id_docente;";
    }
    elseif ($tipo == doctutType) {
        $id_shs = $_SESSION ['studenteHasStageId'];
        $query = "SELECT docente.nome, docente.cognome, docente.email
					FROM docente, studente_has_stage
					WHERE studente_has_stage.id_studente_has_stage = $id_shs
					AND studente_has_stage.docente_tutor_id_docente_tutor = docente.id_docente;";
    }
    elseif ($tipo == ceoType) {
        $id_shs = $_SESSION ['studenteHasStageId'];
        $query = "SELECT azienda.nome_responsabile AS nome, azienda.cognome_responsabile AS cognome, azienda.email_responsabile AS email
					FROM azienda, studente_has_stage
					WHERE studente_has_stage.id_studente_has_stage = $id_shs
					AND studente_has_stage.azienda_id_azienda = azienda.id_azienda;";
    }
    elseif ($tipo == aztutType) {
        $id_shs = $_SESSION ['studenteHasStageId'];
        $query = "SELECT tutor.nome, tutor.cognome, tutor.email
					FROM tutor, studente_has_stage
					WHERE studente_has_stage.id_studente_has_stage = $id_shs
					AND studente_has_stage.tutor_id_tutor = tutor.id_tutor;";
    }
    else {
        $xml->addChild("status", "0");
        return;
    }
    
    if ($result = $connessione->query($query)) {
        $xml->addChild("status", "1");
        while ($row = $result->fetch_assoc())
        {
            $destinatario = $xml->addChild("destinatario");
            $destinatario->addChild("nome", $row['nome']);
            if (isset ($row['cognome'])) {
                $destinatario->addChild("cognome", $row['cognome']);
            }
            $destinatario->addChild("email", $row['email']);
        }
    }
    else {
        $xml->addChild("status", "0");
    }
    echo $xml->asXML();
?>