<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $query = "SELECT * FROM `stage` ORDER BY `inizio_stage`, `durata_stage`";
    $result = $connection->query($query);
    
    $stages = $xml->addChild("stages");
    while ($row = $result->fetch_assoc())
    {
        $stage = $stages->addChild("stage");
        $stage->addChild("id", $row['id_stage']);
        $stage->addChild("inizio", date("d-m-Y", strtotime($row['inizio_stage'])));
        $stage->addChild("durata", $row['durata_stage']);
    }
    
    echo $xml->asXML();
?>