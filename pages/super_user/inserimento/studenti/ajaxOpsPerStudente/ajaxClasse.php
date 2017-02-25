<?php
    include '../../../../functions.php';
    //header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../");    
    $scuola = $_POST['scuola'];
    
    $Query = "SELECT id_classe, nome FROM classe WHERE classe.scuola_id_scuola = $scuola ORDER BY classe.nome";
    
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