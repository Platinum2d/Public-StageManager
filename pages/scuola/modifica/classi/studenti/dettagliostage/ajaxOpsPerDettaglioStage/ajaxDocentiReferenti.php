<?php
    include '../../../../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../../../");    
    $shs = $_POST['studente_has_stage'];
    $chs_result = $connection->query("SELECT classe_has_stage_id_classe_has_stage FROM studente_has_stage WHERE id_studente_has_stage = $shs");
    if (is_object($chs_result) && $chs_result->num_rows > 0) $chs = $chs_result->fetch_assoc()['classe_has_stage_id_classe_has_stage']; else $chs = null;
    
    $idscuola = $_SESSION['userId'];
    
    if (isset($chs) && !empty($chs))
    {
        $query = "SELECT id_docente, doc.nome, doc.cognome, drhchs.id_docente_has_classe_has_stage
                  FROM docente AS doc, docente_referente_has_classe_has_stage AS drhchs 
                  WHERE doc.id_docente = drhchs.docente_id_docente 
                  AND doc.scuola_id_scuola = $idscuola 
                  AND drhchs.classe_has_stage_id_classe_has_stage = $chs ";

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
                    $docente->addChild("drhchs",$row['id_docente_has_classe_has_stage']);
                }
            }

            echo $xml->asXML();
        }
    }