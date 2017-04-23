<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include "../../../../../functions.php";
    $conn = dbConnection("../../../../../../");
    
    $shs = $_POST['shs'];
    $docente = $_POST['docente'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "INSERT INTO docente_referente_has_studente_has_stage (docente_id_docente, studente_has_stage_id_studente_has_stage) VALUES ($docente, $shs)";
    
    $result = $conn->query($query);
    
    if ($result)
    {
        $xml->addChild("esito", "ok");
        $xml->addChild("id_drhshs", $conn->insert_id);
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    
    