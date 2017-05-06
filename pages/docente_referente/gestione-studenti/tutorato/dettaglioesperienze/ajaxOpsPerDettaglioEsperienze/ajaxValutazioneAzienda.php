<?php
    $xmlstr = '<?xml version="1.0" encoding="utf-8" ?><data></data>';
    include '../../../../functions.php';    
    $xml = new SimpleXMLElement ( $xmlstr );

    $connessione = dbConnection("../../../../../");
    
    $id_studente_has_stage = $_POST['id_studente_has_stage'];
    $query = "SELECT * FROM valutazione_studente, studente_has_stage AS shs WHERE id_valutazione_studente = shs.valutazione_studente_id_valutazione_studente "
            ."AND id_studente_has_stage = $id_studente_has_stage";
    
    $result = $connessione->query($query)->fetch_assoc();
    if ($result)
    {
        $valutazione = $xml->addChild("valutazione_studente");    
        $valutazione->addChild("gasl", $result['gestione_ambiente_spazio_lavoro']);
        $valutazione->addChild("cc", $result['collaborazione_comunicazione']);
        $valutazione->addChild("us", $result['uso_strumenti']);
        $valutazione->addChild("rnv", $result['rispetta_norme_vigenti']);
        $valutazione->addChild("ra", $result['rispetto_ambiente']);
        $valutazione->addChild("p", $result['puntualita']);
        $valutazione->addChild("ct", $result['collaborazione_tutor']);
        $valutazione->addChild("lr", $result['lavoro_requisiti']);
        $valutazione->addChild("ctec", $result['conoscenze_tecniche']);
        $valutazione->addChild("anc", $result['acquisire_nuove_conoscenze']);
        $valutazione->addChild("c", $result['commento']);
    }
    
    echo $xml->asXML();