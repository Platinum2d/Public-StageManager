<?php
    include '../../../../../functions.php'; //
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../../");    
    $shs = $_POST['studente_has_stage'];
    
    $query = "SELECT id_docente, doc.nome, doc.cognome, drhshs.id_docente_has_studente_has_stage
              FROM docente AS doc, docente_referente_has_studente_has_stage AS drhshs 
              WHERE doc.id_docente = drhshs.docente_id_docente 
              AND drhshs.studente_has_stage_id_studente_has_stage = $shs";
    
    if (!$result = $connection->query($query))
    {
        echo $connection->error;
    }
    else 
    {
        $docenti = $xml->addChild("docenti");
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $docente = $docenti->addChild("docente");
                $docente->addChild("id",$row['id_docente']);
                $docente->addChild("nome",$row['nome']); 
                $docente->addChild("cognome",$row['cognome']);
                $docente->addChild("drhshs",$row['id_docente_has_studente_has_stage']);
            }
        }
        
        echo $xml->asXML();
    }