<?php
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    $id = intval ($_POST['id']);    
    $classe = $_POST['classe'];
    $anno = $_POST['anno'];
    $error = false;
    
    $esperienze_query = "SELECT * FROM studente_has_stage AS shs, classe_has_stage AS chs "
                      . "WHERE chs.id_classe_has_stage = shs.classe_has_stage_id_classe_has_stage "
                      . "AND chs.classe_id_classe = $classe "
                      . "AND chs.anno_scolastico_id_anno_scolastico = $anno "
                      . "AND shs.studente_id_studente = $id";
    
    $result = $conn->query($esperienze_query);
    if (is_object($result) && $result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $id_studente_has_stage = $row['id_studente_has_stage'];
            
            $lavoro_giornaliero_query = "DELETE FROM lavoro_giornaliero WHERE studente_has_stage_id_studente_has_stage = $id_studente_has_stage";
            if (!$conn->query($lavoro_giornaliero_query)) $errore = true;
            
            $valutazione_stage_query = "DELETE FROM risposta_voce_modulo_stage WHERE studente_has_stage IN (SELECT id_studente_has_stage "
                                                                                                           . "FROM studente_has_stage "
                                                                                                           . "WHERE studente_id_studente = $id)";
            
            $valutazione_studente_query = "DELETE FROM risposta_voce_modulo_studente WHERE studente_has_stage IN (SELECT id_studente_has_stage "
                                                                                                           . "FROM studente_has_stage "
                                                                                                           . "WHERE studente_id_studente = $id)";
            
            $shs_query = "DELETE FROM studente_has_stage WHERE id_studente_has_stage = $id_studente_has_stage";
            if (!$conn->query($shs_query) && !$conn->query($valutazione_stage_query) && !$conn->query($valutazione_studente_query)) $errore = true;
        }
    }
    
    $studente_whishes_figura_professionale_query = "DELETE FROM studente_whishes_figura_professionale WHERE studente_id_studente = $id";
    if (!$conn->query($studente_whishes_figura_professionale_query)) $errore = true;
    
    $studente_attends_classe_query = "DELETE FROM studente_attends_classe WHERE studente_id_studente = $id AND classe_id_classe = $classe AND anno_scolastico_id_anno_scolastico = $anno";
    if (!$conn->query($studente_attends_classe_query)) $errore = true;
    
    if (null !== ($conn->query("SELECT recupera_password_id_recupera_password FROM utente WHERE id_utente = $id")->fetch_assoc()['recupera_password_id_recupera_password']))
    {
        $recupera_password_query = "DELETE FROM recupera_password WHERE id_recupera_password = (SELECT recupera_password_id_recupera_password FROM utente WHERE id_utente = $id)";
        if (!$conn->query($recupera_password_query)) $errore = true;
    }
    
    if (null !== ($conn->query("SELECT immagine_profilo_id_immagine_profilo FROM utente WHERE id_utente = $id")->fetch_assoc()['immagine_profilo_id_immagine_profilo']))
    {
        $url = $conn->query("SELECT URL FROM immagine_profilo, utente WHERE id_immagine_profilo = immagine_profilo_id_immagine_profilo AND id_utente = $id")->fetch_assoc()['URL'];
        $immagine_query = "DELETE FROM immagine_profilo WHERE id_immagine = (SELECT immagine_profilo_id_immagine_profilo FROM utente WHERE id_utente = $id)";
        if (!$conn->query($immagine_query)) $errore = true;
        //unlink("../../../../../media/loads/profimgs/$url");
    }
    
    $studente_query = "DELETE FROM studente WHERE id_studente = $id";
    if (!$conn->query($studente_query)) $errore = true;
    
    $utente_query = "DELETE FROM utente WHERE id_utente = $id";
    if (!$conn->query($utente_query)) $errore = true;
    
    if (!$error)
        echo "ok";
    else
        echo $conn->error;
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*$error = false;

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
        echo "ok";*/