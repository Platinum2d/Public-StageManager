<?php
    include '../../../pages/functions.php';
    
    $connessione = dbConnection ("../../../");
    $username = $connessione->escape_string($_POST ["user"]);
    $psw = MD5 ( $_POST ["password"] );
    $dati_corretti = 0;
    
    $query = "SELECT id_utente, tipo_utente 
                FROM utente
                WHERE username='$username' AND password='$psw';";
    $result = $connessione->query ( $query );
    
    if ($result && $result->num_rows > 0)
    {
    	$dati_corretti = 1;
        $row = $result->fetch_assoc();
        $id_utente = intval ($row ['id_utente']);
        $query = "UPDATE utente 
                    SET autorizzazione_dati_personali = 1
                    WHERE id_utente = $id_utente;";
        if ($result = $connessione->query($query))
        {
            $stato = 1;
        
            $_SESSION ['user'] = $username;
            $_SESSION ['userId'] = $id_utente;
    		$tipo = intval ($row ['tipo_utente']);	
            $_SESSION ['type'] = $tipo;
        
            if ($tipo == studType) {
                $query_stage = "SELECT studente_has_stage.id_studente_has_stage
                                FROM studente, studente_has_stage, classe_has_stage, anno_scolastico, studente_attends_classe 
                                WHERE studente.id_studente = ".$_SESSION ['userId']."
                                AND studente.id_studente=studente_has_stage.studente_id_studente 
                                AND studente_has_stage.classe_has_stage_id_classe_has_stage=classe_has_stage.id_classe_has_stage 
                                AND classe_has_stage.anno_scolastico_id_anno_scolastico=anno_scolastico.id_anno_scolastico 
                                AND anno_scolastico.corrente=1 
                                AND studente_attends_classe.anno_scolastico_id_anno_scolastico=anno_scolastico.id_anno_scolastico 
                                AND studente_attends_classe.classe_id_classe=classe_has_stage.classe_id_classe 
                                AND studente_attends_classe.studente_id_studente=studente.id_studente;";
                $result_stage = $connessione->query ( $query_stage );
                if ($result_stage && $result_stage->num_rows > 0) {
                    $row_stage = $result_stage->fetch_assoc ();
                    $_SESSION ['studenteHasStageId'] = $row_stage ['id_studente_has_stage'];
                }
                else {
                   $stato = 0;
                }
        	}
        }
        else {
            $stato = 0;
        }
    }
    
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $xml->addChild ( "dati_corretti", $dati_corretti );
    if (isset ($stato)) {
    	$xml->addChild ( "stato", $stato );    	
    }
    if (isset ($tipo)) {
    	$xml->addChild ( "tipo", $tipo );
    }
    echo $xml->asXML ();
?>