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
    
    $query = "SELECT * FROM tutor WHERE id_tutor = $idtutor ";
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
        $idazienda = $row['azienda_id_azienda'];
        if (isset($idazienda))
        {
            $query = "SELECT nome_aziendale FROM azienda WHERE id_azienda = ".$row['azienda_id_azienda'];
            $result = $conn->query ($query);
            $secondrow = $result->fetch_assoc();
            $tutor->addChild('id_azienda', $idazienda);
            $tutor->addChild('nome_azienda',$secondrow['nome_aziendale']);
        }
    }
    
    echo $xml->asXML();