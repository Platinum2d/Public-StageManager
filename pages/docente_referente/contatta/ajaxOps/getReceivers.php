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
    
    if ($tipo == ceoType) {
        $query = "SELECT DISTINCT azienda.nome_responsabile AS nome, azienda.cognome_responsabile AS cognome, azienda.email_responsabile AS email, azienda.nome_aziendale
                    FROM azienda, docente_referente_has_studente_has_stage, studente_has_stage, classe_has_stage, anno_scolastico, classe, settore_has_figura_professionale, azienda_needs_figura_professionale
                    WHERE docente_referente_has_studente_has_stage.docente_id_docente = $id_docente
                    AND docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_studente_has_stage
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND classe_has_stage.classe_id_classe = classe.id_classe
                    AND classe.settore_id_settore = settore_has_figura_professionale.settore_id_settore
                    AND azienda_needs_figura_professionale.figura_professionale_id_figura_professionale = settore_has_figura_professionale.figura_professionale_id_figura_professionale
                    AND azienda_needs_figura_professionale.azienda_id_azienda = azienda.id_azienda;";
    }
    elseif ($tipo == doctutType) {
        $query = "SELECT docente.nome, docente.cognome, docente.email, studente.nome AS nome_studente, studente.cognome AS cognome_studente
                    FROM docente, studente, docente_referente_has_studente_has_stage, studente_has_stage, classe_has_stage, anno_scolastico
                    WHERE docente_referente_has_studente_has_stage.docente_id_docente = $id_docente
                    AND docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_studente_has_stage
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND studente_has_stage.docente_tutor_id_docente_tutor = docente.id_docente
                    AND studente_has_stage.studente_id_studente = studente.id_studente;";
    }
    elseif ($tipo == studType) {
        $query = "SELECT studente.nome, studente.cognome, studente.email
                    FROM studente, docente_referente_has_studente_has_stage, studente_has_stage, classe_has_stage, anno_scolastico
                    WHERE docente_referente_has_studente_has_stage.docente_id_docente = $id_docente
                    AND docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_studente_has_stage
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND studente_has_stage.studente_id_studente = studente.id_studente;";
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
            $destinatario->addChild("cognome", $row['cognome']);
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