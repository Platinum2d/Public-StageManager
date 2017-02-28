<?php
    $xmlstr = "<?xml version='1.0' encoding='utf-8' ?><data></data>";
    $xml = new SimpleXMLElement ( $xmlstr );
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $idsegnalazione = $_POST['id'];
    
    $query = "SELECT risolto, descrizione FROM segnala_problema WHERE id_segnala_problema = $idsegnalazione";
    if ($result = $conn->query($query))
    {
        $row = $result->fetch_assoc();
        $xml->addChild("descrizione", $row['descrizione']);
        $xml->addChild("risolto", $row['risolto']);
        echo $xml->asXML();
    }
    else
        echo $conn->error;