<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");

    $query = "SELECT * FROM settore ORDER BY indirizzo_studi ASC";
    $result = $connection->query($query);
    
    if ($result && $result->num_rows > 0)
    {
        $indirizzi = $xml->addChild("scuole");
        while ($row = $result->fetch_assoc())
        {
            $indirizzo = $indirizzi->addChild("scuola");
            $indirizzo->addChild("id", $row['id_settore']);
            $indirizzo->addChild("indirizzo", $row['indirizzo_studi']);
            $indirizzo->addChild("settore", $row['nome_settore']);
        }
    }
    
    echo $xml->asXML();