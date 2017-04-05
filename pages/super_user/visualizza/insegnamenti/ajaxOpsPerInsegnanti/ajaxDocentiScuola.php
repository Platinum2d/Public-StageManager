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
        
    $query = "SELECT id_docente, doc.nome, doc.cognome "
            . "FROM docente AS doc "
            . "WHERE doc.scuola_id_scuola = $scuola";
    
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0)
    {
        $docenti = $xml->addChild("docenti");
        
        while ($row = $result->fetch_assoc())
        {
            $docente = $docenti->addChild("docente");
            
            $docente->addChild("id", $row['id_docente']);
            $docente->addChild("nome", $row['nome']);
            $docente->addChild("cognome", $row['cognome']);
        }
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    
    