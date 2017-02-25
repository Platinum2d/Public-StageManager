<?php
        include '../../../../functions.php';
    //header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../");    
    
    $Query = "SELECT id_scuola, nome FROM scuola ORDER BY nome ASC";
    
    if (!$result = $connection->query($Query))
    {
        echo "prelevazione dei dati non riuscita!";
    }
    else 
    {
        $scuole = $xml->addChild("scuole");
        while ($row = $result->fetch_assoc())
        {
            $scuola = $scuole->addChild("scuola");
            $scuola->addChild("id", $row['id_scuola']);
            $scuola->addChild("nome", $row['nome']);
        }
        
        echo $xml->asXML();
    }
?>