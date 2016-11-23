<?php
        include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );            
    $conn = dbConnection("../../../../../");
    
    $query = "SELECT `id_scuola`, `nome`, `username` FROM `scuola`, `utente` WHERE `id_scuola` = `id_utente` ";
    $result = $conn->query($query);
    $scuole = $xml->addChild("scuole");
    while ($row = $result->fetch_assoc())
    {
        $scuola = $scuole->addChild("scuola");
        $scuola->addChild("id", $row['id_scuola']);
        $scuola->addChild("nome", $row['nome']);
        $scuola->addChild("username", $row['username']);
    }
    
    echo $xml->asXML();
?>