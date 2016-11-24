<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$idclasse = $_POST['id'];
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
        $xml = new SimpleXMLElement ( $xmlstr );


if($result = $connessione->query("SELECT classe.nome AS nome_classe FROM classe WHERE classe.id_classe = $idclasse"))
{
    $row = $result->fetch_assoc();
    $xml->addChild("nome_classe",$row['nome_classe']);
}

echo $xml->asXML();