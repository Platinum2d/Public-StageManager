<?php
    include '../../../../../../functions.php';
    //header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    $error = false;    
    $connection = dbConnection("../../../../../../../");    
    
    $id_studente_has_stage = $_POST['studente_has_stage'];
    $resultget = $connection->query($get_valutazione)->fetch_assoc();
    
    $query_lavoro = "DELETE FROM lavoro_giornaliero WHERE studente_has_stage_id_studente_has_stage = $id_studente_has_stage";
    $query_valutazione_stage = "DELETE FROM risposta_voce_modulo_studente WHERE studente_has_stage_id_studente_has_stage = $id_studente_has_stage";
    $query_valutazione_studente = "DELETE FROM risposta_voce_modulo_stage WHERE studente_has_stage_id_studente_has_stage = $id_studente_has_stage";
    $query = "DELETE FROM studente_has_stage WHERE id_studente_has_stage = $id_studente_has_stage";
    
    if (!$connection->query($query_valutazione_stage)) $error = true;
    if (!$connection->query($query_valutazione_studente)) $error = true;
    
    if ($connection->query($query_lavoro) && $connection->query($query) && !$error)
    {
        echo "ok";
    }
    else
    {
        echo $connection->error;
    }