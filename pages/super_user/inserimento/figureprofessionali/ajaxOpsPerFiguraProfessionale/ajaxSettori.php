<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $indirizzo = $_POST['indirizzo'];
    
    $query = "SELECT id_settore, nome_settore FROM settore WHERE indirizzo_studi = '$indirizzo' ORDER BY nome_settore ASC";
    
    $settori = $xml->addChild("settori");
    $result = $connection->query($query);
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $settore = $settori->addChild("settore");
            $settore->addChild("id", $row['id_settore']);
            $settore->addChild("nome", $row['nome_settore']);
        }
    }
    echo $xml->asXML();