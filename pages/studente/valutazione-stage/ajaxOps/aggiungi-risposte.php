<?php
	include "../../../functions.php";
	if (isset($_SESSION ['studenteHasStageId'])) {
		$shs = $_SESSION ['studenteHasStageId'];
		$conn = dbConnection("../../../../");
		
		$no_empty = true;
		$risposte = json_decode(stripslashes(($_POST['data'])));
		
		$query = "INSERT INTO risposta_voce_modulo_stage (risposta, riga_modulo_stage_id_riga_modulo_stage, colonna_modulo_stage_id_colonna_modulo_stage, studente_has_stage_id_studente_has_stage)
				VALUES ";
		
		foreach ($risposte as $risposta) {
			$valore = trim ($conn->escape_string($risposta->risposta));
			if (empty ($valore)) {
				$no_empty = false;
				break;
			}
			$id_col = intval($conn->escape_string($risposta->id_col));
			$id_rig = intval($conn->escape_string($risposta->id_rig));
			if (!intval($risposta->libera)) {
				$query_risposta = "SELECT opzione
				FROM possibile_risposta_colonna_stage
				WHERE id_possibile_risposta_colonna_stage = $valore;";
				$result = $conn->query ( $query_risposta );
				if ($result && $result->num_rows > 0) {
					$row = $result->fetch_assoc ();
					$valore = $row ['opzione'];
				}
				else {
					echo "Errore nel trovare la risposta.";
				}
			}
			$query .= "('$valore', $id_rig, $id_col, $shs), ";
		}
		$query = substr($query, 0, -2);
		$query .= ";";
		
		if ($no_empty) {
			if ($conn->query ($query))
			{
				echo "ok";
			}
			else {
				echo "Errore nella query";
			}
		}
		else {
			echo "qualche risposta vuota";
		}
	}
	else {
		echo "Nessun'assegnazione ad uno stage";
	}
?>