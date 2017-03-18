<?php
            include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );            
    $conn = dbConnection("../../../../../");
    $scuola = $_SESSION['userId'];
    
    $query = "SELECT DISTINCT `id_classe`, `nome`, `indirizzo_studi`, `nome_settore` FROM `classe`, `settore` WHERE `scuola_id_scuola` = $scuola AND `settore_id_settore` = `id_settore`";
    $result = $conn->query($query);
    $classi = $xml->addChild("classi");
    while ($row = $result->fetch_assoc())
    {
        $classe = $classi->addChild("classe");
        $classe->addChild("id", $row['id_classe']);
        $classe->addChild("nome", $row['nome']);
        $classe->addChild("settore", $row['nome_settore']);
        $classe->addChild("indirizzo_studi", $row['indirizzo_studi']);
    }
    
    echo $xml->asXML();
?>