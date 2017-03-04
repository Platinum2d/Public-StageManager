<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $query = "SELECT DISTINCT indirizzo_studi FROM settore";
    
    $result = $connection->query($query);
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $xml->addChild("indirizzo", $row['indirizzo_studi']);
        }
    }
    echo $xml->asXML();