<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");

    $uid = $_SESSION ['userId'];
    $nm = $db->escape_string ( $_POST ['newdesc'] );
    $id = intval ( $_POST ['id'] );
    if ($db->query ( "UPDATE `lavoro_giornaliero` SET `descrizione`='$nm' WHERE `id_lavoro_giornaliero`=$id AND `studente_id_studente` IN (SELECT `id_studente` FROM `studente` WHERE `tutor_id_tutor`=$uid )" )) {
        $xml->addChild ( "status", 0 );
    } else {
        $xml->addChild ( "status", 1 );
    }
   echo $xml->asXML ();
?>