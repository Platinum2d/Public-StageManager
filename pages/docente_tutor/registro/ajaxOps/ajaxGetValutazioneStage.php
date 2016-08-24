<?php

    $xml = new SimpleXMLElement ("<?xml version=\"1.0\" encoding=\"utf-8\" ?> <data> </data> ");
    include "../../../functions.php";    
    
    $conn = dbConnection("../../../../");
    $idvalutazione = $_POST['id'];
    
    $query = "SELECT `descrizione`, `voto` FROM `valutazione_stage` WHERE `id_valutazione_stage` = $idvalutazione";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $valutazione = $xml->addChild("valutazione");
    $valutazione->addChild("voto", $row['voto']);
    $valutazione->addChild("descrizione", $row['descrizione']);
    
    echo $xml->asXML();
    