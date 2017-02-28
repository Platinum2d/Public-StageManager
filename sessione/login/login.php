<?php
    include '../../pages/functions.php';
    function sessionInformation($usr, $userId, $type, $table) {
        $_SESSION ['user'] = $usr;
        $_SESSION ['userId'] = $userId;
        $_SESSION ['type'] = $type;
        $_SESSION ['nameTable'] = $table;
    }
    
    $usr = $_POST ["user"];
    $psw = MD5 ( $_POST ["password"] );
    $connessione = dbConnection ("../../");
    $usr = $connessione->escape_string($usr);
    $tipo = -1;
    
    $query = "SELECT id_utente, username, password
                FROM utente
                WHERE username='$usr' AND password='$psw' "
            . " AND tipo_utente = 0;";
    $result = $connessione->query ( $query );
    
    $numrows = ($result && $result->num_rows > 0) ? $result->num_rows : 0;
    
    if ($numrows > 0)
    {
        $tipo = 0;
        $row = $result->fetch_assoc();
        $userId = $row ['id_utente'];
        $table = "super_user";
    }
    
    if ($tipo === -1) 
    {
        $query = "SELECT id_utente, username, password, docente_referente, docente_tutor FROM utente, docente WHERE id_utente = id_docente AND username = '$usr' AND password = '$psw'";
        
        $result = $connessione->query($query);    
        if ($result && $result->num_rows > 0)
        {        
            $row = $result->fetch_assoc();
            $userId = $row ['id_utente'];
            $tipo = ($row['docente_tutor'] === "1") ? $tipo = 3 : $tipo = 2;
            $table = "docente";
        }    
    }
    
    if ($tipo == -1) {
        $query = "SELECT id_utente, username, password FROM utente WHERE tipo_utente = 4 AND username = '$usr' AND password = '$psw'";
        $result = $connessione->query ( $query );
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc ();
            $tipo = 4;
            $userId = $row ['id_utente'];
            $table = "azienda";
        }
    }
    
    if ($tipo == -1) {
        $query = "SELECT utente.id_utente, utente.username, utente.password FROM utente WHERE tipo_utente = 6 AND username = '$usr' AND password = '$psw'";
        $result = $connessione->query ( $query );
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc ();
            $tipo = 6;
            $userId = $row ['id_utente'];
            $table = "studente";
        }
        $query_stage = "SELECT studente_has_stage.id_studente_has_stage
                        FROM studente, studente_has_stage, classe_has_stage, anno_scolastico, studente_attends_classe 
                        WHERE studente.id_studente = $userId 
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
    }
    
    if ($tipo == -1) {
        $query = "SELECT id_utente, username, password FROM utente WHERE tipo_utente = 5 AND username = '$usr' AND password = '$psw'";
        $result = $connessione->query ( $query );
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc ();
            $tipo = 5;
            $userId = $row ['id_utente'];
            $table = "tutor";
        }
    }
    if ($tipo != -1) {
        sessionInformation ( $usr, $userId, $tipo, $table );
    }
    
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $xml->addChild ( "tipo", $tipo );
    echo $xml->asXML ();
?>