<?php
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    $id = $_POST['id'];
    
    $error = false;
    
    $query = "DELETE FROM studente_whises_figura_professionale WHERE studente_id_studente = $id;";
    if (!$conn->query($query)){ $error =  true; }
    else
    {
    	$query = "SELECT docente_referente_has_studente_has_stage.id_docente_has_studente_has_stage
    	FROM studente_has_stage, docente_referente_has_studente_has_stage
    	WHERE studente_has_stage.studente_id_studente = $id
    	AND docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_Studente_has_stage;";
    	$result = $conn->query($query);
    	if (!$result){ $error =  true; }
    	else
    	{
    		if ($result->num_rows > 0) {
    			while ($row = $result->fetch_assoc()) {
    				$drhshs = $row ['id_docente_has_studente_has_stage'];
    				$query = "DELETE FROM docente_referente_has_studente_has_stage WHERE id_docente_has_studente_has_stage = $drhshs;";
    				if (!$conn->query($query)){ $error =  true; }
    			}
    		}
    		$query = "DELETE FROM studente_has_stage WHERE studente_id_studente = $id;";
    		if (!$conn->query($query)){ $error =  true; }
    		else
    		{
    			$query = "DELETE FROM studente_attends_classe WHERE studente_id_studente = $id;";
    			if (!$conn->query($query)){ $error =  true; }
    			else
    			{
    				$query = "DELETE FROM studente WHERE id_studente = $id;";
    				if (!$conn->query($query)){ $error =  true; }
    				else
    				{
    					$query = "DELETE FROM utente WHERE id_utente = $id;";
    					if (!$conn->query($query)){ $error =  true; }
    				}
    			}
    		}
    	}
    }
    
    if ($error)
        echo "Errore: query non riuscita o dipendenze esterne non risolte.\nControllare che tutte le entità legate a questo/a studente/studentessa siano state eliminate o modificate opportunamente";
    else
        echo "ok";