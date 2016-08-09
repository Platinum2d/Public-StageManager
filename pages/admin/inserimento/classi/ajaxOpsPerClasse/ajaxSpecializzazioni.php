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
    
    $Query = "SELECT nome FROM specializzazione ORDER BY nome ASC";
    
    if (!$result = $connection->query($Query))
    {
        echo "prelevazione dei dati non riuscita!";
    }
    else 
    {
        while ($row = $result->fetch_assoc())
        {
            $xml->addChild("specializzazione",$row['nome']);            
        }
        
        echo $xml->asXML();
    }
