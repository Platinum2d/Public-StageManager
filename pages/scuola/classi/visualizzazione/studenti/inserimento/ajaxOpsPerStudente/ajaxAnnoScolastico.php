<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../../../functions.php';
    $connection = dbConnection("../../../../../../../");
    
    $query = "SELECT * FROM `anno_scolastico` ORDER BY `nome_anno` DESC";
    $result = $connection->query($query);
    
    $anni = $xml->addChild("anni");
    while ($row = $result->fetch_assoc())
    {
        $anno = $anni->addChild("anno");
        $anno->addChild("id", $row['id_anno_scolastico']);
        $anno->addChild("nome", $row['nome_anno']);
    }
    
    echo $xml->asXML();
?>