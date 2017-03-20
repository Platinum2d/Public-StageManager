<?php
    include '../../../../../../functions.php';
    //header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $connection = dbConnection("../../../../../../../");    
    $exclude = (isset($_POST['exclusion']) && !empty($_POST['exclusion'])) ? ($_POST['exclusion']) : null; 
    
    $Query = "SELECT * FROM docente, utente WHERE id_docente = id_utente ";
    if (isset($exclude)) $Query .= "AND id_docente != $exclude";
    $Query .= " AND tipo_utente = ".doctutType." ORDER BY cognome";
    
    if (!$result = $connection->query($Query))
    {
        echo "prelevazione dei dati non riuscita!";
        echo $Query;
    }
    else 
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