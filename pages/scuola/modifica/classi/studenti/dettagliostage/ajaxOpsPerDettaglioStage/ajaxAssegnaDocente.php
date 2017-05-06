<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include "../../../../../../functions.php";
    $conn = dbConnection("../../../../../../../");
    
    $shs = $_POST['studente_has_stage'];
    $chs_result = $connection->query("SELECT classe_has_stage_id_classe_has_stage FROM studente_has_stage WHERE id_studente_has_stage = $shs");
    if (is_object($chs_result) && $chs_result->num_rows > 0) $chs = $chs_result->fetch_assoc()['classe_has_stage_id_classe_has_stage']; else $chs = null;
    $docente = $_POST['docente'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "INSERT INTO docente_referente_has_classe_has_stage (docente_id_docente, classe_has_stage_id_classe_has_stage) VALUES ($docente, $chs)";
    
    $result = $conn->query($query);
    
    if ($result)
    {
        $xml->addChild("esito", "ok");
        $xml->addChild("id_drhchs", $conn->insert_id);
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    
    