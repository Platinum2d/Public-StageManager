<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../");
    
    $id_tutor = intval($_SESSION['userId']);
    $tipo = intval ($_POST ['type']);
    
    if ($tipo == 2) { //docref
        $query = "SELECT docente.nome, docente.cognome, docente.email, studente.nome AS nome_studente, studente.cognome AS cognome_studente
                    FROM docente, studente, studente_has_stage, docente_referente_has_studente_has_stage
                    WHERE studente_has_stage.tutor_id_tutor = $id_tutor
                    AND studente_has_stage.studente_id_studente = studente.id_studente
                    AND docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_studente_has_stage
                    AND docente_referente_has_studente_has_stage.docente_id_docente = docente.id_docente;";
    }
    elseif ($tipo == 3) { //doctut
        $query = "SELECT docente.nome, docente.cognome, docente.email, studente.nome AS nome_studente, studente.cognome AS cognome_studente
                    FROM docente, studente, studente_has_stage
                    WHERE studente_has_stage.tutor_id_tutor = $id_tutor
                    AND studente_has_stage.studente_id_studente = studente.id_studente
                    AND studente_has_stage.docente_tutor_id_docente_tutor = docente.id_docente;";
    }
    elseif ($tipo == 6) { //stud
        $query = "SELECT studente.nome, studente.cognome, studente.email
                    FROM studente, studente_has_stage
                    WHERE studente_has_stage.tutor_id_tutor = $id_tutor
                    AND studente_has_stage.studente_id_studente = studente.id_studente;";
    }
    elseif ($tipo == 4) { //ceo
        $query = "SELECT azienda.nome_responsabile AS nome, azienda.cognome_responsabile AS cognome, azienda.email_responsabile AS email
                    FROM tutor, azienda
                    WHERE tutor.id_tutor = $id_tutor
                    AND tutor.azienda_id_azienda = azienda.id_azienda;";
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
        }
    }
    else {
        $xml->addChild("status", "0");
    }
    echo $xml->asXML();
?>