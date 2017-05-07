<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../");

    $id_scuola = intval($_SESSION['userId']);
    $tipo = intval ($_POST ['type']);
    
    if ($tipo == docrefType) {
        $query = "SELECT docente.nome, docente.cognome, docente.email, classe.nome AS nome_classe
                    FROM docente, classe_has_stage, anno_scolastico, docente_referente_has_classe_has_stage, classe
                    WHERE docente_referente_has_classe_has_stage.docente_id_docente = docente.id_docente
                    AND docente_referente_has_classe_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND classe_has_stage.classe_id_classe = classe.id_classe
                    AND classe.scuola_id_scuola = $id_scuola;";
    }
    elseif ($tipo == doctutType) {
        $query = "SELECT docente.nome, docente.cognome, docente.email, studente.nome AS nome_studente, studente.cognome AS cognome_studente
                    FROM docente, studente, studente_has_stage, classe_has_stage, anno_scolastico, classe
                    WHERE studente_has_stage.studente_id_studente = studente.id_studente
                    AND studente_has_stage.docente_tutor_id_docente_tutor = docente.id_docente
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND classe_has_stage.classe_id_classe = classe.id_classe
                    AND classe.scuola_id_scuola = $id_scuola;";
    }
    elseif ($tipo == studType) {
        $query = "SELECT studente.nome, studente.cognome, studente.email
                    FROM studente, studente_has_stage, classe_has_stage, anno_scolastico, classe
                    WHERE studente_has_stage.studente_id_studente = studente.id_studente
                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                    AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    AND classe_has_stage.classe_id_classe = classe.id_classe
                    AND classe.scuola_id_scuola = $id_scuola ;";
    }
    elseif ($tipo == ceoType) {
        $query = "SELECT DISTINCT azienda.nome_responsabile AS nome, azienda.cognome_responsabile AS cognome, azienda.email_responsabile AS email, azienda.nome_aziendale AS nome_aziendale
                    FROM azienda, azienda_needs_figura_professionale, settore_has_figura_professionale, classe
                    WHERE azienda_needs_figura_professionale.azienda_id_azienda = azienda.id_azienda
                    AND azienda_needs_figura_professionale.figura_professionale_id_figura_professionale = settore_has_figura_professionale.figura_professionale_id_figura_professionale
                    AND settore_has_figura_professionale.settore_id_settore = classe.settore_id_settore
                    AND classe.scuola_id_scuola = $id_scuola;";
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
            if (isset ($row ['nome_classe'])) {
            	$destinatario->addChild("nome_classe", $row['nome_classe']);
            }
        }
    }
    else {
        $xml->addChild("status", "0");
    }
    echo $xml->asXML();
?>