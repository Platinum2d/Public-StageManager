<?php
    include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $conn = dbConnection("../../../../../");
    $idazienda = $_POST['idazienda'];
    
    $query = "SELECT * FROM azienda, utente WHERE tipo_utente = 4 AND id_utente = $idazienda AND id_azienda = $idazienda ";
    $result = $conn->query($query);
    
    $aziende = $xml->addChild('aziende');
    while ($row = $result->fetch_assoc())
    {
        $azienda = $aziende->addChild('azienda');
        $azienda->addChild('username',$row['username']);
        $azienda->addChild('nome_aziendale',$row['nome_aziendale']);
        $azienda->addChild('citta',$row['citta_aziendale']);
        $azienda->addChild('cap',$row['CAP']);
        $azienda->addChild('indirizzo',$row['indirizzo']);
        $azienda->addChild('telefono_aziendale',$row['telefono_aziendale']);
        $azienda->addChild('email_aziendale',$row['email_aziendale']);
        $azienda->addChild('sito_web',$row['sito_web']);
        $azienda->addChild('nome_responsabile',$row['nome_responsabile']);
        $azienda->addChild('cognome_responsabile',$row['cognome_responsabile']);
        $azienda->addChild('telefono_responsabile',$row['telefono_responsabile']);
        $azienda->addChild('email_responsabile',$row['email_responsabile']);
    }
    
    echo $xml->asXML();
?>