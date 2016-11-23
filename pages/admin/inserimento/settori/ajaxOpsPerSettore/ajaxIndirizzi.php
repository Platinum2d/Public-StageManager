<?php
    //header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $query = "SELECT DISTINCT(indirizzo_studi) AS indirizzi FROM settore";
    $result = $connection->query($query);
    
    $indirizzi = $xml->addChild("indirizzi");
    while ($row = $result->fetch_assoc())
    {
        $indirizzi->addChild("indirizzo", $row['indirizzi']);
    }
    
    echo $xml->asXML();
?>