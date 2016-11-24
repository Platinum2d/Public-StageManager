<?php
    $xml = new SimpleXMLElement ( "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data></data>" );
    $conn = new mysqli("localhost", "root", "", 'alternanza_scuola_lavoro');
    $ownerid = $_POST['owner'];
    $lastid = $_POST['lastid'];
    
    //METTERE GLI ID DELLE SCUOLE, ALTRIMENTI LE VA A CONSIDERARE TUTTE!!!!!!! (CLAUSOLA WHERE NELLA SUBQUERY SELECT MAX())
    $query = "SELECT id_scuola_writes_to_scuola, messaggio FROM scuola_writes_to_scuola WHERE scuola_id_scuola_destinatario = $ownerid AND id_scuola_writes_to_scuola > $lastid";
    
    $result = $conn->query($query);   
    
    if ($result && $result->num_rows > 0)
    {
        $messaggi = $xml->addChild("messaggi");
        while ($row = $result->fetch_assoc())
        {
            $messaggio = $messaggi->addChild("messaggio");
            $messaggio->addChild("id", $row['id_scuola_writes_to_scuola']);
            $messaggio->addChild("testo", $row['messaggio']);
        }
    }
    else
        $xml->addChild("empty");
    
    echo $xml->asXML();