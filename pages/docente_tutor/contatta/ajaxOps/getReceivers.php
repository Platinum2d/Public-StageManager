<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../");

    $id_docente = intval($_SESSION['userId']);
    $tipo = intval ($_POST ['type']);
    
    if ($tipo == scuolaType) {
        $query = "SELECT scuola.nome, scuola.email
                    FROM scuola, anno_scolastico, classe_has_docente, classe
                    WHERE classe_has_docente.docente_id_docente = $id_docente
                    AND classe_has_docente.classe_id_classe = classe.id_classe
                    AND classe.scuola_id_scuola = scuola.id_scuola
                    AND classe_has_docente.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1;";
    }
    elseif ($tipo == docrefType) {
        $query = "SELECT docente.nome, docente.cognome, docente.email, studente.nome AS nome_studente, studente.cognome AS cognome_studente
                    FROM docente, studente, studente_has_stage, docente_referente_has_studente_has_stage, classe_has_stage, anno_scolastico
                    WHERE studente_has_stage.docente_tutor_id_docente_tutor = $id_docente
                    AND studente_has_stage.studente_id_studente = studente.id_studente
                    AND docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_studente_has_stage
                    AND docente_referente_has_studente_has_stage.docente_id_docente = docente.id_docente
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1;";
    }
    elseif ($tipo == studType) {
        $query = "SELECT studente.nome, studente.cognome, studente.email
                    FROM studente, studente_has_stage, classe_has_stage, anno_scolastico
                    WHERE studente_has_stage.docente_tutor_id_docente_tutor = $id_docente
                    AND studente_has_stage.studente_id_studente = studente.id_studente
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1;";
    }
    elseif ($tipo == aztutType) {
        $query = "SELECT tutor.nome, tutor.cognome, tutor.email, studente.nome AS nome_studente, studente.cognome AS cognome_studente
                    FROM studente, studente_has_stage, classe_has_stage, anno_scolastico, tutor
                    WHERE studente_has_stage.docente_tutor_id_docente_tutor = $id_docente
                    AND studente_has_stage.tutor_id_tutor = tutor.id_tutor
                    AND studente_has_stage.studente_id_studente = studente.id_studente
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1;";
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
            if (isset ($row ['nome_studente'])) {
                $destinatario->addChild("nome_studente", $row['nome_studente']);
            }
            if (isset ($row ['cognome_studente'])) {
                $destinatario->addChild("cognome_studente", $row['cognome_studente']);
            }
            if (isset ($row ['nome_aziendale'])) {
                $destinatario->addChild("nome_aziendale", $row['nome_aziendale']);
            }
        }
    }
    else {
        $xml->addChild("status", "0");
    }
    echo $xml->asXML();
?>