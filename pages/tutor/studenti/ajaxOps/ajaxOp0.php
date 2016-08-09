<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");

    $idstud=$_POST["idstud"];
    $query_line = $db->query (  "SELECT * FROM `lavoro_giornaliero` 
                                    WHERE `lavoro_giornaliero`.`studente_id_studente`=$idstud 
                                    ORDER BY `data` DESC;" );
    while ( $work_line = $query_line->fetch_assoc () ) {
        $line = $xml->addChild ( "line" );
        $line->addChild ( "id", $work_line ['id_lavoro_giornaliero'] );
        $line->addChild ( "date", $work_line ['data'] );
        $line->addChild ( "desc", $work_line ['descrizione'] );
    }
   echo $xml->asXML ();
?>