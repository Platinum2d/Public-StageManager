<?php
    
include '../../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
$connessione = dbConnection("../../../../../../");
$idstud = $_POST['id'];
    
$query = "SELECT * FROM utente, studente WHERE id_utente = id_studente AND id_studente = $idstud";
            
if($result = $connessione->query($query))
{
    $row = $result->fetch_assoc();
    $xml->addChild('nome' , $row['nome'] );
    $xml->addChild('cognome' , $row['cognome'] );
    $xml->addChild('username' , $row['username'] );
    $xml->addChild('citta' , $row['citta'] );
    $xml->addChild('email' , $row['email'] );
    $xml->addChild('telefono' , $row['telefono'] );
        
    echo $xml->asXML();
}
?>