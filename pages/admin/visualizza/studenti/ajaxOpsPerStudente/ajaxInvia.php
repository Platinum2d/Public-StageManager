
<?php

include '../../../../functions.php';

$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr ); 
        
$connessione = dbConnection("../../../../../");
$id = $_POST['id'];
$username = $connessione->escape_string($_POST['username']);
$password = $_POST['password'];
$nome = $connessione->escape_string($_POST['nome']);
$cognome = $connessione->escape_string($_POST['cognome']);
$citta = $connessione->escape_string($_POST['citta']);
$mail = $connessione->escape_string($_POST['mail']);
$telefono = $connessione->escape_string($_POST['telefono']);
$iniziostage = (isset($_POST['iniziostage'])) ? $_POST['iniziostage'] : 'NULL';
$duratastage = (isset($_POST['duratastage'])) ? $_POST['duratastage'] : 'NULL';
$visitaazienda = $_POST['visitaazienda'];

$idclasse = $_POST['classe'];
$idazienda = ($_POST['azienda'] !== 'disassegna') ? $_POST['azienda'] : 'NULL';
$iddocente = ($_POST['docente'] !== 'disassegna') ? $_POST['docente'] : 'NULL';
$idtutor = ($_POST['tutor'] !== 'disassegna') ? $_POST['tutor'] : 'NULL';

$Query = "UPDATE `studente` SET `username` = '$username', ";
if ($password !== "immutato") $Query .= "`password` = '".md5($password)."', ";
$Query .= "`nome` = '$nome', `cognome` = '$cognome', `citta` = '$citta', `email` = '$mail', `telefono` = '$telefono'";

if ($iniziostage !== 'NULL') { $Query = $Query . ",`inizio_stage` = '$iniziostage',"; } else { $Query = $Query . ",`inizio_stage` = $iniziostage,"; }
if ($duratastage !== 'NULL') { $Query = $Query . "`durata_stage` = '$duratastage',"; } else { $Query = $Query . "`durata_stage` = $duratastage,"; }
$Query = $Query . "`visita_azienda` = $visitaazienda, `classe_id_classe` = $idclasse, `azienda_id_azienda` = $idazienda , `docente_id_docente` = $iddocente, `tutor_id_tutor` = $idtutor WHERE `studente`.`id_studente` = $id";

$connessione->query("SET FOREIGN_KEY_CONTROLS = 0");
if ($connessione->query($Query))
{
    $xml->addChild('user',$username);
    $xml->addChild('nome',$nome);
    $xml->addChild('cognome',$cognome);
    $xml->addChild('query',$Query);
    echo $xml->asXML();
}
else
    echo $connessione->error;
$connessione->query("SET FOREIGN_KEY_CONTROLS = 1");