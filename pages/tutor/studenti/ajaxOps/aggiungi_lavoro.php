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
    $day = intval ($_POST ['day']);
    $month = intval ($_POST ['month']);
    $year = intval ($_POST ['year']);
    $lavoro = $db->escape_string ( $_POST ['lavoro'] );
    $insegnamenti = $db->escape_string ( $_POST ['insegnamenti'] );
    $commento = $db->escape_string ( $_POST ['commento'] );
    
    if ($commento == "") {
        $commento = "NULL";
    }
    else {
        $commento = "'".$commento."'";
    }
    
    if ($db->query ( "INSERT INTO `lavoro_giornaliero` (`data`,`lavoro_svolto`,`insegnamenti`,`commento`,`studente_has_stage_id_studente_has_stage`)
                        VALUES ('$year-$month-$day','$lavoro','$insegnamenti',$commento,$id);" )) {
        $xml->addChild ( "status", 0 );
    } else {
        $xml->addChild ( "status", 1 );
    }
        
   echo $xml->asXML ();
?>