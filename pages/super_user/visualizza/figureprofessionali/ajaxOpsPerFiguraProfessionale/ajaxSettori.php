<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    
    $xml = new SimpleXMLElement ( $xmlstr );
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");    
    $id_figura = $_POST['idfigura'];
    $query = "SELECT * FROM settore AS s, settore_has_figura_professionale as shfp WHERE shfp.settore_id_settore = s.id_settore AND shfp.figura_professionale_id_figura_professionale = $id_figura";
        
    $result = $conn->query($query);
    if ($result->num_rows > 0)
    {
        $settori = $xml->addChild("settori");
        while ($row = $result->fetch_assoc())
        {
            $settore = $settori->addChild("settore");
            $settore->addChild("id", $row['id_settore']);
            $settore->addChild("id_associazione", $row['id_settore_has_figura_professionale']);
            $settore->addChild("indirizzo_studi", $row['indirizzo_studi']);
            $settore->addChild("nome_settore", $row['nome_settore']);
        }
    }
    
    echo $xml->asXML();