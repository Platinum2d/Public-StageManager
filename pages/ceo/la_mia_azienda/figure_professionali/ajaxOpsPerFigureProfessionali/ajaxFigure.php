<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
        
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
        
    $azienda = $_SESSION['userId'];
    
    $query = "SELECT * FROM figura_professionale WHERE id_figura_professionale NOT IN (SELECT figura_professionale_id_figura_professionale "
            . "FROM azienda_needs_figura_professionale WHERE azienda_id_azienda = $azienda)";
                
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