<?php
	include '../../../functions.php';
    
    $conn = dbConnection("../../../../");

    $gasl = $conn->escape_string ($_POST ['gestione_ambiente_spazio_lavoro']);
    $cc = $conn->escape_string ($_POST ['collaborazione_comunicazione']);
    $us = $conn->escape_string ($_POST ['uso_strumenti']);
    $cca = $conn->escape_string ($_POST ['complessita_compito_atteggiamento']);
    $vgs = $conn->escape_string ($_POST ['valutazione_gestione_sicurezza']);
    $cl = $conn->escape_string ($_POST ['competenze_linguistiche']);
    $ccap = $conn->escape_string ($_POST ['conoscenza_coerenza_approfondimento']);
    $ee = $conn->escape_string ($_POST ['efficacia_esposizone']);
    $qp = $conn->escape_string ($_POST ['qualita_processo']);
    $ef = $conn->escape_string ($_POST ['efficacia_prodotto']);
    $comm = $conn->escape_string ($_POST ['commento']);
    $id_studente_has_stage = intval ($_POST ['id_studente_has_stage']);
	
	$sql = "select `valutazione_studente_id_valutazione_studente` from `studente_has_stage` where `id_studente_has_stage`=  $id_studente_has_stage;";
	
	$Result = $conn->query ( $sql );
	if ($Result) {
		$row = $Result->fetch_assoc ();
		$valquery = $row ['valutazione_studente_id_valutazione_studente'];
		$execute = "UPDATE `valutazione_studente` SET `gestione_ambiente_spazio_lavoro`=$gasl,`collaborazione_comunicazione`=$cc,`uso_strumenti`=$us,`rispetta_norme_vigenti`=$cca,`rispetto_ambiente`=$vgs,`puntualita`=$cl,`collaborazione_tutor`= $ccap,`lavoro_requisiti`=$ee,`conoscenze_tecniche`=$qp,`acquisire_nuove_conoscenze`=$ef, `commento`='$comm' WHERE `id_valutazione_studente`= $valquery;";
		$Result = $conn->query ( $execute );
		if ($Result) echo "ok";
		else echo $conn->error;	
	}
	else echo $conn->error;
?>