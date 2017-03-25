<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $classe = $_POST['classe'];
    $anno = $_POST['anno'];
    $docente = $_POST['docente'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "INSERT INTO classe_has_docente (classe_id_classe, docente_id_docente, anno_scolastico_id_anno_scolastico) VALUES ($classe, $docente, $anno)";
    
    $result = $conn->query($query);
    
    if ($result)
    {
        $xml->addChild("esito", "ok");
        $xml->addChild("id_chd", $conn->insert_id);
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    
    