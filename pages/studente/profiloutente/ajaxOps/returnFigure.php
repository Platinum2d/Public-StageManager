<?php
	include '../../../functions.php';
	$connessione = dbConnection ("../../../../");
	
	$id_preferenza = intval ($_POST ['preferenza']);
	$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
	$xml = new SimpleXMLElement ( $xmlstr );
	
	$query = "SELECT figura_professionale.id_figura_professionale, figura_professionale.nome
	FROM studente_whises_figura_professionale, figura_professionale
	WHERE studente_whises_figura_professionale.id_studente_whises_figura_professionale = $id_preferenza
	AND studente_whises_figura_professionale.figura_professionale_id_figura_professionale = figura_professionale.id_figura_professionale;";
	$result = $connessione->query ( $query );
	if ($result->num_rows > 0) {
		$work_line = $result->fetch_assoc ();
		$xml->addChild ( "status", "1" );
		$xml->addChild ( "id", $work_line ['id_figura_professionale'] );
		$xml->addChild ( "nome", $work_line ['nome'] );
	}
	else {
		$xml->addChild ( "status", "0" );
	}
	
	echo $xml->asXML ();
?>