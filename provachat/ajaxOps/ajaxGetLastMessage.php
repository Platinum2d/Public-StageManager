<?php
    $xml = new SimpleXMLElement ( "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data></data>" );
    $conn = new mysqli("localhost", "root", "", 'alternanza_scuola_lavoro');
    $ownerid = $_POST['owner'];
    
    //METTERE GLI ID DELLE SCUOLE, ALTRIMENTI LE VA A CONSIDERARE TUTTE!!!!!!! (CLAUSOLA WHERE NELLA SUBQUERY SELECT MAX())
    $query = "SELECT MAX(id_scuola_writes_to_scuola) FROM scuola_writes_to_scuola WHERE scuola_id_scuola_destinatario = $ownerid;";
    
    $result = $conn->query($query);   
    
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $xml->addChild("id", $row['MAX(id_scuola_writes_to_scuola)']);
        $query = "SELECT messaggio FROM scuola_writes_to_scuola WHERE scuola_id_scuola_destinatario = $ownerid AND id_scuola_writes_to_scuola = ( SELECT MAX(id_scuola_writes_to_scuola) FROM scuola_writes_to_scuola WHERE scuola_id_scuola_destinatario = $ownerid);";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $xml->addChild("messaggio", $row['messaggio']);
    }
    else
        $xml->addChild("id", "empty");
    
    echo $xml->asXML();