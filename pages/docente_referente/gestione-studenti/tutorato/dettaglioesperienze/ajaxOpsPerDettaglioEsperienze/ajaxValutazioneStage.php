<?php
    $xmlstr = '<?xml version="1.0" encoding="utf-8" ?><data></data>';
    include '../../../../functions.php';    
    $xml = new SimpleXMLElement ( $xmlstr );

    $connessione = dbConnection("../../../../../");
    
    $id_studente_has_stage = $_POST['id_studente_has_stage'];
    
    $query = "SELECT id_valutazione_stage, voto, descrizione FROM valutazione_stage, studente_has_stage AS shs "
            . "WHERE id_valutazione_stage = shs.valutazione_stage_id_valutazione_stage AND id_studente_has_stage = $id_studente_has_stage";
    $result = $connessione->query($query)->fetch_assoc();
    
    if ($result)
    {
        $valutazione = $xml->addChild("valutazione_stage");
        $valutazione->addChild("voto", $result['voto']);
        $valutazione->addChild("descrizione", $result['descrizione']);
    }
    
    echo $xml->asXML();