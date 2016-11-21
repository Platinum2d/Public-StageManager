<?php
    include '../../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../../");
        
    $classe_has_stage_id = $_POST['classe_stage'];
    $studente = $_POST['studente'];
    
    $query_general = "SELECT autorizzazione_registro, id_studente_has_stage FROM studente_has_stage WHERE studente_id_studente = $studente AND classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";    
    $query_azienda = "SELECT shs.azienda_id_azienda, nome_aziendale, visita_azienda FROM azienda AS az, studente_has_stage AS shs WHERE shs.azienda_id_azienda = az.id_azienda AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";
    $query_docente = "SELECT shs.docente_id_docente, doc.nome, doc.cognome FROM docente AS doc, studente_has_stage AS shs WHERE shs.docente_id_docente = doc.id_docente AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";
    $query_tutor = "SELECT shs.tutor_id_tutor, tut.nome, tut.cognome FROM tutor AS tut, studente_has_stage AS shs WHERE shs.tutor_id_tutor = tut.id_tutor AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";
        
    $result = $connessione->query($query_general);
        
    if ($result->num_rows > 0)
    { 
        $general_results = $result->fetch_assoc();
        
        $result = $connessione->query($query_azienda);
        $azienda_results = $result->fetch_assoc();
            
        $result = $connessione->query($query_docente);
        $docente_results = $result->fetch_assoc();
            
        $result = $connessione->query($query_tutor);
        $tutor_results = $result->fetch_assoc();
            
        $xml->addChild("studente_has_stage", $general_results['id_studente_has_stage']);
        $xml->addChild("autorizzazione", $general_results['autorizzazione_registro']);
        $azienda = $xml->addChild("azienda");
        $azienda->addChild("id", $azienda_results['azienda_id_azienda']);
        $azienda->addChild("nome", $azienda_results['nome_aziendale']);
        $azienda->addChild("visitata", $azienda_results['visita_azienda']);
        $docente = $xml->addChild("docente");
        $docente->addChild("id", $docente_results['docente_id_docente']);
        $docente->addChild("nome", $docente_results['nome']);
        $docente->addChild("cognome", $docente_results['cognome']);
        $tutor = $xml->addChild("tutor");
        $tutor->addChild("id", $tutor_results['tutor_id_tutor']);
        $tutor->addChild("nome", $tutor_results['nome']);
        $tutor->addChild("cognome", $tutor_results['cognome']);
    }
    echo $xml->asXML();