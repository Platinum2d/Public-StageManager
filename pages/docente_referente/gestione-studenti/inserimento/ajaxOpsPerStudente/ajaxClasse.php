<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include '../../../../functions.php';
    //header ( "Content-Type: application/xml" );

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../");
    $id_docente = $_SESSION['userId'];
    
    $Query = "SELECT id_classe, nome 
                FROM docente_referente_has_classe_has_stage, classe_has_stage, classe, anno_scolastico 
                WHERE docente_referente_has_classe_has_stage.docente_id_docente = $id_docente 
                AND docente_referente_has_classe_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                AND classe_has_stage.classe_id_classe = classe.id_classe
                AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                AND anno_scolastico.corrente = 1
                ORDER BY classe.nome;";
    
    if (!$result = $connection->query($Query))
    {
        echo "prelevazione dei dati non riuscita!";
    }
    else 
    {
        $classi = $xml->addChild("classi");
        while ($row = $result->fetch_assoc())
        {
            $classe = $classi->addChild("classe");
            $classe->addChild("id", $row['id_classe']);
            $classe->addChild("nome", $row['nome']);
        }
        
        echo $xml->asXML();
    }
?>