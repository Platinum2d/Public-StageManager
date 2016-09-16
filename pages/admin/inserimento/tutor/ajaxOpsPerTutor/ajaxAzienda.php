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
    
    $Query = "SELECT id_azienda, nome_aziendale FROM azienda ORDER BY nome_aziendale";
    
    if (!$result = $connection->query($Query))
    {
        echo "dio";
    }
    else 
    {
        $aziende = $xml->addChild("aziende");
        while ($row = $result->fetch_assoc())
        {
            $azienda = $aziende->addChild("azienda");
            $azienda->addChild("id",$row['id_azienda']);
            $azienda->addChild("nome",$row['nome_aziendale']);            
        }
        
        echo $xml->asXML();
    }