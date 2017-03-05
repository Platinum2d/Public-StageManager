<?php
        include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );            
    $conn = dbConnection("../../../../../");
    $exception = (empty($exception) || !isset($exception)) ? null : $_POST['exception'];   
    
    $query = (empty($exception) || !isset($exception)) ? "SELECT `id_scuola`, `nome`, `username` FROM `scuola`, `utente` WHERE `id_scuola` = `id_utente` " : "SELECT `id_scuola`, `nome`, `username` FROM `scuola`, `utente` WHERE `id_scuola` = `id_utente` AND `id_scuola` != $exception";
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