<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $query = "SELECT * FROM `settore` ORDER BY `indirizzo_studi`, `nome_settore`";
    $result = $connection->query($query);
    
    $settori = $xml->addChild("settori");
    while ($row = $result->fetch_assoc())
    {
        $settore = $settori->addChild("settore");
        $settore->addChild("id", $row['id_settore']);
        $settore->addChild("indirizzo", $row['indirizzo_studi']);
        $settore->addChild("nome", $row['nome_settore']);
    }
    
    echo $xml->asXML();