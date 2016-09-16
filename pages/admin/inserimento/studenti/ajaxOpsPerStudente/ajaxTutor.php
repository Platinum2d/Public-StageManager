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
    $idAzienda = $_POST['idAzienda'];
    
    
    $Query = "SELECT nome, cognome FROM utente, tutor WHERE id_utente = id_tutor AND azienda_id_azienda = $idAzienda ORDER BY cognome";
    
    if (!$result = $connection->query($Query))
    {
        echo "prelevazione dei dati non riuscita!";
    }
    else 
    {
        $tutors = $xml->addChild("tutors");
        while ($row = $result->fetch_assoc())
        {
            $tutor = $tutors->addChild("tutor");
            $tutor->addChild("nome", $row['nome']);
            $tutor->addChild("cognome", $row['cognome']);
        }
        
        echo $xml->asXML();
    }