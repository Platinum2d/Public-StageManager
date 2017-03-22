<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $classe = $_POST['classe'];
    $anno = $_POST['anno'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "SELECT id_classe_has_docente, id_docente, doc.nome, doc.cognome
    FROM docente AS doc, classe_has_docente AS chd, classe AS c 
    WHERE chd.classe_id_classe = c.id_classe 
    AND chd.docente_id_docente = doc.id_docente 
    AND chd.classe_id_classe = $classe
    AND chd.anno_scolastico_id_anno_scolastico = $anno
    AND c.scuola_id_scuola = ".$_SESSION['userId'];
    
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0)
    {
        $docenti = $xml->addChild("docenti");
        
        while ($row = $result->fetch_assoc())
        {
            $docente = $docenti->addChild("docente");
            
            $docente->addChild("id", $row['id_docente']);
            $docente->addChild("id_chd", $row['id_classe_has_docente']);
            $docente->addChild("nome", $row['nome']);
            $docente->addChild("cognome", $row['cognome']);
        }
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    
    