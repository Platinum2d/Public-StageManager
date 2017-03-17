<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../");

    $id_azienda = $_POST['id'];
    
    $query =  "SELECT DISTINCT azienda.nome_aziendale, azienda.citta_aziendale, azienda.CAP, azienda.indirizzo, azienda.telefono_aziendale, azienda.email_aziendale, azienda.sito_web, azienda.nome_responsabile, azienda.cognome_responsabile, azienda.telefono_responsabile, azienda.email_responsabile
                FROM azienda
                WHERE azienda.id_azienda = $id_azienda;";
    
    if ($result = $connessione->query($query)) {
        $row = $result->fetch_assoc();
        $xml->addChild("status", "1");
        $xml->addChild("nome_aziendale", $row['nome_aziendale']);
        $xml->addChild("citta", $row['citta_aziendale']);
        $xml->addChild("cap", $row['CAP']);
        $xml->addChild("indirizzo", $row['indirizzo']);
        $xml->addChild("telefono_aziendale", $row['telefono_aziendale']);
        $xml->addChild("email_aziendale", $row['email_aziendale']);
        $xml->addChild("sito", $row['sito_web']);
        $xml->addChild("nome_responsabile", $row['nome_responsabile']);
        $xml->addChild("cognome_responsabile", $row['cognome_responsabile']);
        $xml->addChild("telefono_responsabile", $row['telefono_responsabile']);
        $xml->addChild("email_responsabile", $row['email_responsabile']);  
    }
    else {
        $xml->addChild("status", "0");
    }    
    echo $xml->asXML();
?>