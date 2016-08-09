<?php

    include '../../../../functions.php';
    $connessione = dbConnection("../../../../../");
    $idclasse = $_POST['id'];
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
        $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "SELECT * FROM specializzazione";
    $result = $connessione->query($query);
    $specializzazioni = $xml->addChild("specializzazioni");
    while ($row = $result->fetch_assoc())
    {
        $specializzazione = $specializzazioni->addChild("specializzazione");
        $specializzazione->addChild("id",$row['id_specializzazione']);
        $specializzazione->addChild("nome",$row['nome']);
    }
    
    echo $xml->asXML();