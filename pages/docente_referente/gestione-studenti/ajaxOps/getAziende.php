<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
        $connessione = dbConnection("../../../../");
    
        $id_classe = $_POST['id'];
        
        $query =  "SELECT DISTINCT azienda.id_azienda, azienda.nome_aziendale
                    FROM azienda, azienda_needs_figura_professionale, settore_has_figura_professionale, classe
                    WHERE azienda.id_azienda = azienda_needs_figura_professionale.azienda_id_azienda
                    AND azienda_needs_figura_professionale.figura_professionale_id_figura_professionale = settore_has_figura_professionale.figura_professionale_id_figura_professionale
                    AND settore_has_figura_professionale.settore_id_settore = classe.settore_id_settore
                    AND classe.id_classe = $id_classe
                    ORDER BY azienda.nome_aziendale;";
        
        if ($result = $connessione->query($query)) {
            $xml->addChild("status", "1");
            while ($row = $result->fetch_assoc())
            {
                $azienda = $xml->addChild("azienda");
                $azienda->addChild("id", $row['id_azienda']);
                $azienda->addChild("nome", $row['nome_aziendale']);
            }        
        }
        else {
            $xml->addChild("status", "0");
        }    
        echo $xml->asXML();
?>