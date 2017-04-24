<?php
    include '../../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../");    
    $classe = $_POST['classe'];
    
    $Query = "SELECT * FROM classe WHERE scuola_id_scuola IN (SELECT scuola_id_scuola FROM classe WHERE id_classe = $classe) ORDER BY nome ASC";
    
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
            $classe->addChild("id",$row['id_classe']);
            $classe->addChild("nome",$row['nome']);            
        }        
        echo $xml->asXML();
    }
?>