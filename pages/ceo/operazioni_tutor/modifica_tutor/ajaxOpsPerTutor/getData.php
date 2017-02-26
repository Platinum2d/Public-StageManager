<?php
    include "../../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $conn = dbConnection("../../../../../");
    $idtutor = $_POST['idtutor'];
    
    $query = "SELECT * FROM utente, tutor WHERE id_utente = id_tutor AND id_tutor = $idtutor ";
    $result = $conn->query($query);
    
    $tutors = $xml->addChild('tutors');
    while ($row = $result->fetch_assoc())
    {
        $tutor = $tutors->addChild('tutor');
        $tutor->addChild('username',$row['username']);
        $tutor->addChild('nome',$row['nome']);
        $tutor->addChild('cognome',$row['cognome']);
        $tutor->addChild('telefono',$row['telefono']);
        $tutor->addChild('email',$row['email']);
    }
    
    echo $xml->asXML();
?>