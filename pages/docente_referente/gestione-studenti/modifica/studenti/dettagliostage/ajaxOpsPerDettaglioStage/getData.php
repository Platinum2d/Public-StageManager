<?php
    include '../../../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../../../");
        
    $classe_has_stage_id = $_POST['classe_stage'];
    $studente = $_POST['studente'];
    $studente_has_stage_id = $_POST['studente_has_stage'];
    
    $query_general = "SELECT visita_azienda, autorizzazione_registro FROM studente_has_stage WHERE studente_id_studente = $studente AND classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";    
    $query_azienda = "SELECT shs.azienda_id_azienda, nome_aziendale FROM azienda AS az, studente_has_stage AS shs WHERE shs.azienda_id_azienda = az.id_azienda AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";
    $query_docente = "SELECT shs.docente_tutor_id_docente_tutor, doc.nome, doc.cognome FROM docente AS doc, studente_has_stage AS shs WHERE shs.docente_tutor_id_docente_tutor = doc.id_docente AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";
    $query_tutor = "SELECT shs.tutor_id_tutor, tut.nome, tut.cognome FROM tutor AS tut, studente_has_stage AS shs WHERE shs.tutor_id_tutor = tut.id_tutor AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id;";
        
    $result = $connessione->query($query_general);
        
    if (is_object($result) && $result->num_rows > 0)
        $general_results = $result->fetch_assoc();
        
    $result = $connessione->query($query_azienda);
    $azienda_results = $result->fetch_assoc();
    
    $result = $connessione->query($query_docente);
    if (is_object($result) && $result->num_rows > 0)
        $docente_results = $result->fetch_assoc();
            
    $result = $connessione->query($query_tutor);
    if (is_object($result) && $result->num_rows > 0)
        $tutor_results = $result->fetch_assoc();

    $xml->addChild("autorizzazione", $general_results['autorizzazione_registro']);
    $xml->addChild("visitata", $general_results['visita_azienda']);

    $query_valutazioni = "SELECT modulo_valutazione_studente_id_modulo_valutazione_studente, modulo_valutazione_stage_id_modulo_valutazione_stage "
                             . "FROM classe_has_stage "
                             . "WHERE id_classe_has_stage = $classe_has_stage_id";
    $result_valutazioni = $connessione->query($query_valutazioni)->fetch_assoc();
    $id_valutazione_studente = $result_valutazioni['modulo_valutazione_studente_id_modulo_valutazione_studente'];
    $id_valutazione_stage = $result_valutazioni['modulo_valutazione_stage_id_modulo_valutazione_stage'];

    if (isset($id_valutazione_stage) && !empty($id_valutazione_stage)) $xml->addChild("valutazione_stage", $id_valutazione_stage);
    if (isset($id_valutazione_studente) && !empty($id_valutazione_studente)) $xml->addChild("valutazione_studente", $id_valutazione_studente);

    $azienda = $xml->addChild("azienda");
    $azienda->addChild("id", $azienda_results['azienda_id_azienda']);
    $azienda->addChild("nome", $azienda_results['nome_aziendale']);
    $azienda->addChild("visitata", $azienda_results['visita_azienda']);
    $docente = $xml->addChild("docente");
    $docente->addChild("id", $docente_results['docente_tutor_id_docente_tutor']);
    $docente->addChild("nome", $docente_results['nome']);
    $docente->addChild("cognome", $docente_results['cognome']);
    $tutor = $xml->addChild("tutor");
    $tutor->addChild("id", $tutor_results['tutor_id_tutor']);
    $tutor->addChild("nome", $tutor_results['nome']);
    $tutor->addChild("cognome", $tutor_results['cognome']);
    
    echo $xml->asXML();