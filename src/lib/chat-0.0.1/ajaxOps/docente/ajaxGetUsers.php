<?php
    $xml = new SimpleXMLElement ( "<?xml version=\"1.0\" encoding=\"utf-8\" ?> <data> </data>" );
    include "../../../../../pages/functions.php";
    
    $conn = dbConnection("../../../../../");   
    
    $query = "SELECT id_studente AS idstud, studente.cognome AS cognome_studente, studente.nome AS nome_studente, studente.username AS username_studente,
    azienda.id_azienda AS idaz, azienda.nome_aziendale AS nome_azienda, azienda.username AS username_azienda, 
    id_tutor AS idtut, tutor.cognome AS cognome_tutor, tutor.nome AS nome_tutor, tutor.username AS username_tutor
    FROM studente, azienda, tutor
    WHERE studente.tutor_id_tutor = tutor.id_tutor
    AND studente.azienda_id_azienda = azienda.id_azienda
    AND studente.docente_id_docente = ".$_SESSION['userId']." ORDER BY studente.cognome ASC;";
    
    $result = $conn->query($query);
    $utenti = $xml->addChild("utenti");
    while ($row = $result->fetch_assoc())
    {
        $gruppo = $utenti->addChild("gruppo");
        $studente = $gruppo->addChild("studente");
        $studente->addChild("id", $row['idstud']);
        $studente->addChild("cognome", $row['cognome_studente']);
        $studente->addChild("nome", $row['nome_studente']);
        $studente->addChild("username", $row['username_studente']);
        $azienda = $gruppo->addChild("azienda");
        $azienda->addChild("id", $row['idaz']);
        $azienda->addChild("nome", $row['nome_azienda']);
        $azienda->addChild("username", $row['username_azienda']);
        $tutor = $gruppo->addChild("tutor");
        $tutor->addChild("id",$row['idtut']);
        $tutor->addChild("cognome", $row['cognome_tutor']);
        $tutor->addChild("nome",$row['nome_tutor']);
        $tutor->addChild("username",$row['username_tutor']);
    }
    
    echo $xml->asXML();