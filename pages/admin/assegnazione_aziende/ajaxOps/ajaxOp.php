<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection();
    $classe = intval ( $_POST ['classe'] );

        // prendo gli studenti della classe
        $studenti = $xml->addChild ( "studenti" );
        $q_studenti = $db->query ( "SELECT DISTINCT `cognome`,`nome`,`id_studente`,`azienda_id_azienda` FROM `studente`,`azienda` WHERE `classe_id_classe`=$classe" );
        if ($q_studenti->num_rows !== 0)
        {
        while ( $studente = $q_studenti->fetch_assoc () ) {
            $xml_studente = $studenti->addChild ( "studente" );
            $xml_studente->addChild ( "nome", $studente ['nome'] );
            $xml_studente->addChild ( "cognome", $studente ['cognome'] );
            $xml_studente->addChild ( "id", $studente ['id_studente'] );
            $idstudente = $studente ['id_studente'];
            
            $id = $studente ['azienda_id_azienda'];
            if ($id == null) {
                $id = "Non assegnato";
                $xml_studente->addChild ( "nome_aziendale", $id );
            } else {
                $q_nome_az = $db->query ( "SELECT `nome_aziendale`,`id_azienda` FROM `azienda` WHERE `id_azienda`=$id" );
                $nome_az = $q_nome_az->fetch_assoc ();
                $xml_studente->addChild ( "nome_aziendale", $nome_az ['nome_aziendale'] );
            }
        }
        // prendo la preferenza di quel singolo studente
        $query = "SELECT preferenza_id_preferenza FROM studente_has_preferenza WHERE studente_id_studente = $idstudente";
        $result = $db->query($query);
        $diocane = 'dio';        
        if ($result->num_rows !== 0)
        {
            $row = $result->fetch_assoc();
            $query = "SELECT nome FROM preferenza WHERE id_preferenza = ".$row['preferenza_id_preferenza'];
            $result = $db->query($query);
            $row = $result->fetch_assoc();
            
            $xml_studente->addChild("preferenza",$row['nome']);            
        }
        
//         prendo le aziende relazionate alle classe
        $aziende = $xml->addChild ( "aziende" );
        $q_aziende = $db->query ( "SELECT  `nome_aziendale`, `id_azienda` 
                                    FROM  `azienda`, `azienda_has_specializzazione`, `classe`
                                    WHERE `classe`.id_classe = $classe
                                	AND `classe`.specializzazione_id_specializzazione = `azienda_has_specializzazione`.specializzazione_id_specializzazione
                                    AND `azienda_has_specializzazione`.azienda_id_azienda = `azienda`.id_azienda" );
        while ( $studente = $q_aziende->fetch_assoc () ) {
            $xml_azienda = $aziende->addChild ( "azienda" );
            $xml_azienda->addChild ( "rs", $studente ['nome_aziendale'] );
            $xml_azienda->addChild ( "id", $studente ['id_azienda'] );
        }
        
        }
    echo $xml->asXML ();
        
?>        
