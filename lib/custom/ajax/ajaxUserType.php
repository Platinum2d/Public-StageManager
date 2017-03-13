<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    include "../../../pages/functions.php";
    $conn = dbConnection("../../../");
    
    $id_utente = $_POST['id'];
    $query = "SELECT tipo_utente FROM utente WHERE id_utente = $id_utente";
    
    if ($result = $conn->query($query))
    {
        $xml->addChild("esito", "ok");
        switch (intval($result->fetch_assoc()['tipo_utente']))
        {
            case studType: $xml->addChild("tipo", "studente");  break;
        }
        
        echo $xml->asXML();
    }
    else
        echo $conn->error;
    