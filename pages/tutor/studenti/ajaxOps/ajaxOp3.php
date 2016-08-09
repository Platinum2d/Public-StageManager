<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    
    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");

    $id = intval ( $_POST ['sid'] );
    $day = $_POST ['day'];
    $month = $_POST ['month'];
    $year = $_POST ['year'];
    $desc = $db->escape_string ( $_POST ['desc'] );
    
    if ($db->query ( "INSERT INTO `lavoro_giornaliero` (`data`,`descrizione`,`studente_id_studente`) VALUES ('$year-$month-$day','$desc',$id)" )) {
        $xml->addChild ( "status", 0 );
    } else {
        $xml->addChild ( "status", 1 );
    }
        
   echo $xml->asXML ();
?>