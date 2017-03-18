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
    
    $query = "SELECT * FROM utente, docente WHERE id_utente = id_docente AND id_docente = $iddocente ";
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
        $azienda->addChild('tipo_utente',$row['tipo_utente']);
    }
    
    echo $xml->asXML();
?>