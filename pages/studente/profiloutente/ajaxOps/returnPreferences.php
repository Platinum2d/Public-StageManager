<?php
    include '../../../functions.php';    
    $connessione = dbConnection ("../../../../");
    
    $id_utente = $_SESSION ['userId'];
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "SELECT studente_whises_figura_professionale.id_studente_whises_figura_professionale, figura_professionale.nome, studente_whises_figura_professionale.preferenza_principale
                FROM studente_whises_figura_professionale, figura_professionale
                WHERE studente_whises_figura_professionale.studente_id_studente = $id_utente
                AND studente_whises_figura_professionale.figura_professionale_id_figura_professionale = figura_professionale.id_figura_professionale;";
    $result = $connessione->query ( $query );
    
    while ( $work_line = $result->fetch_assoc () ) {
        $line = $xml->addChild ( "preference" );
        $line->addChild ( "id", $work_line ['id_studente_whises_figura_professionale'] );
        $line->addChild ( "name", $work_line['nome'] );
        $line->addChild ( "priority", $work_line ['preferenza_principale'] );
    }
    
    echo $xml->asXML ();
?>