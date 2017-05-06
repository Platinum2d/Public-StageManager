<?php
    include '../../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../../");
    
    $id_valutazione_studente = $_POST['valutazione_studente'];
    $query = "SELECT * FROM valutazione_studente WHERE id_valutazione_studente = $id_valutazione_studente";
    
    $valutazione = $xml->addChild("valutazione");
    $result = $connessione->query($query)->fetch_assoc();
    
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
    
    echo $xml->asXML();