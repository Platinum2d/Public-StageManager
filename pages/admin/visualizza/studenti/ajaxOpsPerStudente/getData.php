<?php

include '../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
$connessione = dbConnection("../../../../../");
$idstud = $_POST['id'];

if($result = $connessione->query("SELECT * FROM studente WHERE id_studente = $idstud"))
{
    $row = $result->fetch_assoc();
    $xml->addChild('nome' , $row['nome'] );
    $xml->addChild('cognome' , $row['cognome'] );
    $xml->addChild('username' , $row['username'] );
    $xml->addChild('citta' , $row['citta'] );
    $xml->addChild('email' , $row['email'] );
    $xml->addChild('telefono' , $row['telefono'] );
    $xml->addChild('inizio_stage' , $row['inizio_stage'] );
    $xml->addChild('durata_stage' , $row['durata_stage'] );
    $xml->addChild('visita_azienda' , $row['visita_azienda'] );
    
    $Query = "SELECT preferenza.nome FROM `preferenza`,`studente`,`studente_has_preferenza`"
            . " WHERE id_studente = studente_id_studente"
            . " AND id_preferenza = preferenza_id_preferenza"
            . " AND id_studente = $idstud ORDER BY preferenza.nome ASC";
    $resultpref = $connessione->query($Query);
    $preferenze = $xml->addChild("preferenze");
    while ($rowpref = $resultpref->fetch_assoc())
    {
        $preferenze->addChild("preferenza",$rowpref['nome']);
    }
    
    
    if (isset($row['classe_id_classe']))
    {
        $Query = "SELECT nome FROM classe WHERE id_classe = ".$row['classe_id_classe'];
        $result = $connessione->query($Query);
        if ($result->num_rows !== 0) { $secondrow = $result->fetch_assoc(); $xml->addChild('classe' , $secondrow['nome'] );}
    }
    
    if (isset($row['azienda_id_azienda']))
    {
        $Query = "SELECT nome_aziendale, id_azienda FROM azienda WHERE id_azienda = ".$row['azienda_id_azienda'];
        $result = $connessione->query($Query);
        if ($result->num_rows !== 0) { $secondrow = $result->fetch_assoc(); $xml->addChild('azienda' , $secondrow['nome_aziendale'] ); $xml->addChild('id_azienda' , $secondrow['id_azienda'] );}
    }
    
    if (isset($row['docente_id_docente']))
    {
        $Query = "SELECT nome, cognome FROM docente WHERE id_docente = ".$row['docente_id_docente'];
        $result = $connessione->query($Query);
        if ($result->num_rows !== 0) { $secondrow = $result->fetch_assoc(); $xml->addChild('docente' , $secondrow['cognome']. " ".$secondrow['nome'] );}
    }
    
    if (isset($row['tutor_id_tutor']))
    {
        $Query = "SELECT nome, cognome FROM tutor WHERE id_tutor = ".$row['tutor_id_tutor'];
        $result = $connessione->query($Query);
        if ($result->num_rows !== 0){ $secondrow = $result->fetch_assoc(); $xml->addChild('tutor' , $secondrow['cognome'] . " " . $secondrow['nome'] );}
    }    
    
    echo $xml->asXML();
}