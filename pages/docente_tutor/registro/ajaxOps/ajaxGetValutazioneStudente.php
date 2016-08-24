<?php

    $xml = new SimpleXMLElement ("<?xml version=\"1.0\" encoding=\"utf-8\" ?> <data> </data> ");
    include "../../../functions.php";    
        
    $conn = dbConnection("../../../../");
    $idvalutazione = $_POST['id'];
    
    $query = "SELECT * FROM `valutazione_studente` WHERE `id_valutazione_studente` = $idvalutazione";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $valutazione = $xml->addChild("valutazione");
    $valutazione->addChild("gestione_ambiente_spazio_lavoro", $row['gestione_ambiente_spazio_lavoro']);
    $valutazione->addChild("collaborazione_comunicazione", $row['collaborazione_comunicazione']);
    $valutazione->addChild("uso_strumenti", $row['uso_strumenti']);
    $valutazione->addChild("rispetta_norme_vigenti", $row['rispetta_norme_vigenti']);
    $valutazione->addChild("rispetto_ambiente", $row['rispetto_ambiente']);
    $valutazione->addChild("puntualita", $row['puntualita']);
    $valutazione->addChild("collaborazione_tutor", $row['collaborazione_tutor']);
    $valutazione->addChild("lavoro_requisiti", $row['lavoro_requisiti']);
    $valutazione->addChild("conoscenze_tecniche", $row['conoscenze_tecniche']);
    $valutazione->addChild("acquisire_nuove_conoscenze", $row['acquisire_nuove_conoscenze']);
    
    echo $xml->asXML();

