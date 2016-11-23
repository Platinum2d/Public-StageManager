<?php
	include '../../../functions.php';
	$conn = dbConnection ("../../../../");
	
	$gasl = $_POST ['gestione_ambiente_spazio_lavoro'];
	$cc = $_POST ['collaborazione_comunicazione'];
	$us = $_POST ['uso_strumenti'];
	$cca = $_POST ['complessita_compito_atteggiamento'];
	$vgs = $_POST ['valutazione_gestione_sicurezza'];
	$cl = $_POST ['competenze_linguistiche'];
	$ccap = $_POST ['conoscenza_coerenza_approfondimento'];
	$ee = $_POST ['efficacia_esposizone'];
	$qp = $_POST ['qualita_processo'];
	$ef = $_POST ['efficacia_prodotto'];
	$id_studente_has_stage = $_POST ['id_studente_has_stage'];
	
	// /vedere se il campo valutazione nella tabella studente è null o no e dal risultato ottenuto fare insert o update
	
	$sql = "select `valutazione_studente_id_valutazione_studente` from `studente_has_stage` where `id_studente_has_stage`=  $id_studente_has_stage;";
	
	$Result = $conn->query ( $sql );
	if ($Result) {
		$row = $Result->fetch_assoc ();
		$valquery = $row ['valutazione_studente_id_valutazione_studente'];
		$execute = "UPDATE `valutazione_studente` SET `gestione_ambiente_spazio_lavoro`=$gasl,`collaborazione_comunicazione`=$cc,`uso_strumenti`=$us,`rispetta_norme_vigenti`=$cca,`rispetto_ambiente`=$vgs,`puntualita`=$cl,`collaborazione_tutor`= $ccap,`lavoro_requisiti`=$ee,`conoscenze_tecniche`=$qp,`acquisire_nuove_conoscenze`=$ef where `id_valutazione_studente`= $valquery;";
		$Result = $conn->query ( $execute );
		if ($Result) echo "ok";
		else echo $conn->error;
	
	}
	else echo $conn->error;
?>