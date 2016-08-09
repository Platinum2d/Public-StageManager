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


if($result = $connessione->query("SELECT classe.nome AS nome_classe, specializzazione.nome AS nome_spec FROM classe, specializzazione WHERE classe.specializzazione_id_specializzazione = specializzazione.id_specializzazione AND classe.id_classe = $idclasse"))
{
    $row = $result->fetch_assoc();
    $xml->addChild("nome_classe",$row['nome_classe']);
    $xml->addChild("nome_spec",$row['nome_spec']);
}

echo $xml->asXML();