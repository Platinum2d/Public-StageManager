<?php
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");
    $idAzienda = $_SESSION['userId'];

        // prendo gli studenti della classe
        $studenti = $xml->addChild ( "studenti" );
        $q_studenti = $db->query ( "SELECT DISTINCT`cognome`,`nome`,`id_studente`,`azienda_id_azienda`,`tutor_id_tutor` FROM `studente`,`azienda` WHERE `azienda_id_azienda`=$idAzienda" );
       
        while ( $studente = $q_studenti->fetch_assoc () ) {
            $xml_studente = $studenti->addChild ( "studente" );
            $xml_studente->addChild ( "nome", $studente ['nome'] );
            $xml_studente->addChild ( "cognome", $studente ['cognome'] );
            $xml_studente->addChild ( "id", $studente ['id_studente'] );
            $xml_studente->addChild ( "idTutor", $studente ['tutor_id_tutor'] );
            $id = $studente ['tutor_id_tutor'];
               if ($id == null) {
                $id = "Non assegnato";
                $xml_studente->addChild ( "nome_tutor", $id );
            } else {
                $q_nome_az = $db->query ( "SELECT `nome`,`cognome`,`id_tutor` FROM `tutor` WHERE `id_tutor`=$id" );
                $nome_az = $q_nome_az->fetch_assoc ();
                $xml_studente->addChild ( "nomeTutor", $nome_az ['nome'] );
                $xml_studente->addChild ( "cognomeTutor", $nome_az ['cognome'] );
            }
            

        }
        
  
           
        
         
       
        // prendo i tutor relativi all' azienda 
        $tutors = $xml->addChild ( "tutors" );
        $q_tutor = $db->query ( "SELECT  `nome`,`cognome`,`azienda_id_azienda`,`id_tutor`
                                    FROM  `tutor`
                                    WHERE `azienda_id_azienda` = $idAzienda " );
        while ( $studente = $q_tutor->fetch_assoc () ) {
            $xml_tutor = $tutors->addChild ( "tutor" );
            $xml_tutor->addChild ( "st", $studente ['nome'] );
             $xml_tutor->addChild ( "sc", $studente ['cognome'] );
            $xml_tutor->addChild ( "it", $studente ['id_tutor'] );
        }
        
       // prendo i tutor relativi allo studente 

       
        
        
        
    echo $xml->asXML ();
    