<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");

    $uid = intval ($_SESSION ['userId']);
    $nm = $db->escape_string ( $_POST ['newdesc'] );
    $id = intval ( $_POST ['id'] );
    $day = intval ($_POST ['day']);
    $month = intval ($_POST ['month']);
    $year = intval ($_POST ['year']);
    $query = "UPDATE `lavoro_giornaliero` 
                SET `descrizione` = '$nm', `data` = '$year-$month-$day'
                WHERE `id_lavoro_giornaliero` = $id;";
    if ($db->query ($query)) {
        $xml->addChild ( "status", 0 );
    } else {
        $xml->addChild ( "status", 1 );
    }
   echo $xml->asXML ();
?>