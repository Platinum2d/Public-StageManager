<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");

    $uid = intval ($_SESSION ['userId']);
    $lavoro = $db->escape_string ( $_POST ['lavoro'] );
    $insegnamenti = $db->escape_string ( $_POST ['insegnamenti'] );
    $commento = $db->escape_string ( $_POST ['commento'] );
    $id = intval ( $_POST ['id'] );
    $day = intval ($_POST ['day']);
    $month = intval ($_POST ['month']);
    $year = intval ($_POST ['year']);
    
    if ($commento == "") {
        $commento = "NULL";
    }
    else {
        $commento = "'".$commento."'";
    }
    
    $query = "UPDATE `lavoro_giornaliero` 
                SET `lavoro_svolto` = '$lavoro', `insegnamenti` = '$insegnamenti', `commento` = $commento, `data` = '$year-$month-$day'
                WHERE `id_lavoro_giornaliero` = $id;";
    if ($db->query ($query)) {
        $xml->addChild ( "status", 0 );
    } else {
        $xml->addChild ( "status", 1 );
    }
   echo $xml->asXML ();
?>