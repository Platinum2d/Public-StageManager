<?php
    include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $conn = dbConnection("../../../../../");
    $iddocente = $_POST['iddocente'];
    
    $query = "SELECT * FROM docente WHERE id_docente = $iddocente ";
    $result = $conn->query($query);
    
    $aziende = $xml->addChild('docenti');
    while ($row = $result->fetch_assoc())
    {
        $azienda = $aziende->addChild('docente');
        $azienda->addChild('username',$row['username']);
        $azienda->addChild('nome',$row['nome']);
        $azienda->addChild('cognome',$row['cognome']);
        $azienda->addChild('telefono',$row['telefono']);
        $azienda->addChild('email',$row['email']);
        $azienda->addChild('docente_referente',$row['docente_referente']);
        $azienda->addChild('docente_tutor',$row['docente_tutor']);
        $azienda->addChild('super_user',$row['super_user']);
    }
    
    echo $xml->asXML();