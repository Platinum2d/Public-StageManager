<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $scuola = $_POST['scuola'];
        
    $query = "SELECT c.id_classe, c.nome AS nomeclasse, sect.nome_settore, sect.indirizzo_studi 
                                    FROM classe AS c, settore AS sect 
                                    WHERE c.settore_id_settore = sect.id_settore
                                    AND c.scuola_id_scuola = $scuola 
                                    ORDER BY indirizzo_studi, nome_settore";
    
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0)
    {
        $classi = $xml->addChild("classi");
        
        while ($row = $result->fetch_assoc())
        {
            $classe = $classi->addChild("classe");
            
            $classe->addChild("id", $row['id_classe']);
            $classe->addChild("nome_classe", $row['nomeclasse']);
            $classe->addChild("nome_settore", $row['nome_settore']);
            $classe->addChild("indirizzo_studi", $row['indirizzo_studi']);
        }
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    
    