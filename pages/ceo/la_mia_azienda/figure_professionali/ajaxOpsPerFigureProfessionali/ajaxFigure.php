<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
        
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $settore = $_POST['settore'];
    $azienda = $_SESSION['userId'];
    
    $query = "SELECT f.id_figura_professionale, f.nome "
            . "FROM figura_professionale AS f, settore_has_figura_professionale AS shfp "
            . "WHERE shfp.figura_professionale_id_figura_professionale = f.id_figura_professionale "
            . "AND shfp.settore_id_settore = $settore "
            . "AND f.id_figura_professionale NOT IN ("
                                                    . "SELECT figura_professionale_id_figura_professionale "
                                                    . "FROM azienda_needs_figura_professionale "
                                                    . "WHERE azienda_needs_figura_professionale.azienda_id_azienda = $azienda AND 
                                                       azienda_needs_figura_professionale.settore_id_settore = $settore                                                        
                                                    )";
                
    $result = $connection->query($query);
    if ($result && $result->num_rows > 0)
    {
        $figure = $xml->addChild("figure");
        while ($row = $result->fetch_assoc())
        {
            $figura = $figure->addChild("figura");
            
            $figura->addChild("id", $row['id_figura_professionale']);
            $figura->addChild("nome", $row['nome']);
        }
    }
    
    echo $xml->asXML();