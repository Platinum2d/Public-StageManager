<?php
    include '../../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../../");
        
    $classe_has_stage_id = $_POST['classe_stage'];
    $studente = $_POST['studente'];
        
    $query = "SELECT AutorizzazioneRegistro, shs.azienda_id_azienda, nome_aziendale, visita_azienda, docente_id_docente, doc.nome AS docnome, doc.cognome AS doccognome, tutor_id_tutor, tut.nome AS tutnome, tut.cognome AS tutcognome "
            . "FROM studente_has_stage AS shs, azienda AS az, docente AS doc, tutor AS tut WHERE shs.azienda_id_azienda = az.id_azienda AND shs.docente_id_docente = doc.id_docente "
            . "AND shs.tutor_id_tutor = tut.id_tutor AND shs.studente_id_studente = $studente AND shs.classe_has_stage_id_classe_has_stage = $classe_has_stage_id";    
    $result = $connessione->query($query);
        
    if ($result->num_rows > 0)
    {        
        while ($row = $result->fetch_assoc())
        {
            $xml->addChild("autorizzazione", $row['AutorizzazioneRegistro']);
            $azienda = $xml->addChild("azienda");
            $azienda->addChild("id", $row['azienda_id_azienda']);
            $azienda->addChild("nome", $row['nome_aziendale']);
            $azienda->addChild("visitata", $row['visita_azienda']);
            $docente = $xml->addChild("docente");
            $docente->addChild("id", $row['docente_id_docente']);
            $docente->addChild("nome", $row['docnome']);
            $docente->addChild("cognome", $row['doccognome']);
            $tutor = $xml->addChild("tutor");
            $tutor->addChild("id", $row['tutor_id_tutor']);
            $tutor->addChild("nome", $row['tutnome']);
            $tutor->addChild("cognome", $row['tutcognome']);
        }        
        echo $xml->asXML();
    }
    else
        echo "no";