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
    $idazienda = $_POST['idazienda'];
    
    $query = "SELECT * FROM tutor WHERE azienda_id_azienda = $idazienda";
    $result = $connection->query($query);
    if ($result->num_rows !== 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $tutors = $xml->addChild('tutors');
            $tutor = $tutors->addChild('tutor');
            $tutor->addChild('id',$row['id_tutor']);
            $tutor->addChild('nome',$row['nome']);
            $tutor->addChild('cognome',$row['cognome']);
        }
        
        echo $xml->asXML();
    }