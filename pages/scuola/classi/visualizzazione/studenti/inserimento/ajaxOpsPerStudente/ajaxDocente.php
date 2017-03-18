<?php
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    include '../../../../../../functions.php';
    //header ( "Content-Type: application/xml" )

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../../../");    
    
    $Query = "SELECT id_docente, username, nome, cognome FROM utente, docente WHERE id_docente = id_utente ORDER BY cognome";
    
    if (!$result = $connection->query($Query))
    {
        echo "prelevazione dei dati non riuscita!";
    }
    else 
    {
        $docenti = $xml->addChild("docenti");
        while ($row = $result->fetch_assoc())
        {
            $docente = $docenti->addChild("docente");
            $docente->addChild("id", $row['id_docente']);
            $docente->addChild("username", $row['username']);
            $docente->addChild("nome", $row['nome']);
            $docente->addChild("cognome", $row['cognome']);
        }
        
        echo $xml->asXML();
    }
?>