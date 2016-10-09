<?php
            include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );            
    $conn = dbConnection("../../../../../");
    $classe = $_POST['classe'];
    
    $query = "SELECT classe.nome AS nomeclasse, settore_id_settore, indirizzo_studi, nome_settore, id_scuola, scuola.nome AS nomescuola FROM classe, settore, scuola WHERE settore_id_settore = id_settore AND scuola_id_scuola = id_scuola AND  id_classe = $classe;";
    $result = $conn->query($query);
    $classi = $xml->addChild("classi");
    while ($row = $result->fetch_assoc())
    {
        $classe = $classi->addChild("classe");
        $classe->addChild("nome", $row['nomeclasse']);
        $classe->addChild("id_settore", $row['settore_id_settore']);
        $classe->addChild("settore", $row['nome_settore']);
        $classe->addChild("indirizzo", $row['indirizzo_studi']);
        $classe->addChild("id_scuola", $row['id_scuola']);
        $classe->addChild("nome_scuola", $row['nomescuola']);
    }
    
    echo $xml->asXML();