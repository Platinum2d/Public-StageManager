<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../");
    
    $id_docente = $_POST['id'];
    
    $query =  "SELECT docente.nome, docente.cognome, docente.telefono, docente.email
                FROM docente
                WHERE docente.id_docente = $id_docente;";
    
    if ($result = $connessione->query($query)) {
        $xml->addChild("status", "1");
        $row = $result->fetch_assoc();
        $xml->addChild("nome", $row['nome']);
        $xml->addChild("cognome", $row['cognome']);
        $xml->addChild("telefono", $row['telefono']);
        $xml->addChild("email", $row['email']);
    }
    else {
        $xml->addChild("status", "0");
    }
    echo $xml->asXML();
?>