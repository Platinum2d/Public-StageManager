<?php
        include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );            
    $conn = dbConnection("../../../../../");
    $exception = $_POST['exception'];
    
    $query = (empty($exception) || !isset($exception)) ? "SELECT * FROM `settore`" : "SELECT * FROM `settore` WHERE `id_settore` != $exception";
    $result = $conn->query($query);
    $settori = $xml->addChild("settori");
    while ($row = $result->fetch_assoc())
    {
        $settore = $settori->addChild("settore");
        $settore->addChild("id", $row['id_settore']);
        $settore->addChild("indirizzo_studi", $row['indirizzo_studi']);
        $settore->addChild("nome_settore", $row['nome_settore']);
    }
    
    echo $xml->asXML();