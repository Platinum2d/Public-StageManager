<?php
        include '../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../");

    $idscuola = $_POST['id'];
    
    $query =  "SELECT * FROM utente, scuola WHERE id_utente = id_scuola AND id_scuola = $idscuola";
    
    $result = $connessione->query($query);
    
    $scuola = $xml->addChild("scuola");
    while ($row = $result->fetch_assoc())
    {
        $scuola->addChild("username", $row['username']);
        $scuola->addChild("nome", $row['nome']);
        $scuola->addChild("citta", $row['citta']);
        $scuola->addChild("CAP", $row['CAP']);
        $scuola->addChild("indirizzo", $row['indirizzo']);
        $scuola->addChild("telefono", $row['telefono']);
        $scuola->addChild("email", $row['email']);
        $scuola->addChild("sito_web", $row['sito_web']);
        $scuola->addChild("nome_resp", $row['nome_responsabile']);
        $scuola->addChild("cognome_resp", $row['cognome_responsabile']);
        $scuola->addChild("telefono_resp", $row['telefono_responsabile']);
        $scuola->addChild("email_resp", $row['email_responsabile']);
    }
    
    echo $xml->asXML(); 