<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $query = "SELECT * FROM `scuola` ORDER BY `nome`";
    $result = $connection->query($query);
    
    $scuole = $xml->addChild("scuole");
    while ($row = $result->fetch_assoc())
    {
        $scuola = $scuole->addChild("scuola");
        $scuola->addChild("id", $row['id_scuola']);
        $scuola->addChild("nome", $row['nome']);
    }
    
    echo $xml->asXML();
?>