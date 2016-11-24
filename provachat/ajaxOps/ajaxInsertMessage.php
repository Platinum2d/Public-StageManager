<?php
    $xml = new SimpleXMLElement ( "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data></data>" );
        
    $conn = new mysqli("localhost", "root", "", 'alternanza_scuola_lavoro');
    $idmittente = $_POST['mittente'];
    $iddestinatario = $_POST['destinatario'];
    $messaggio = $_POST['messaggio'];
        
    $query = "INSERT INTO scuola_writes_to_scuola (scuola_id_scuola_mittente, scuola_id_scuola_destinatario, messaggio, data_ora) VALUES ($idmittente, $iddestinatario, '".$conn->escape_string($messaggio)."',"
            . " CURRENT_TIMESTAMP)";
    if ($conn->query($query))
    {
        $xml->addChild("esito", "positivo");       
    }
    else 
    {
        $xml->addChild("esito", "negativo");
    }
    
    echo $xml->asXML();