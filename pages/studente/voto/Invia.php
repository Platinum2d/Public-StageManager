<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    $MySQLConnection = dbConnection("../../../");
    $Voto = htmlspecialchars ( $_POST ['voto'] );
    $Descrizione = htmlspecialchars ( $_POST ['descrizione'] );
        
    $Voto = stripslashes ( $Voto );
    $Descrizione = stripslashes ( $Descrizione );
        
    $Voto = $MySQLConnection->escape_string ( $Voto );
    $Descrizione = $MySQLConnection->escape_string ( $Descrizione );
    // MySQL parameters, temporanei, cambiare con le apposite credenziali
        
        
    if ($MySQLConnection->connect_error) 
    {
//        $_SESSION ['grade_sent'] = 1; // connessione al database fallita
//                                         // die("Errore di connessione: ".$MySQLConnection->connect_error);
        echo "invio della valutazione NON riuscito";
    }
        
      $queryStageId = "SELECT classe_has_stage.stage_id_stage 
						FROM studente, studente_attends_classe, anno_scolastico, classe_has_stage, classe 
						WHERE studente.id_studente = " . $_SESSION['userId'] . " 
						AND anno_scolastico.corrente = 1 
						AND studente.scuola_id_scuola = classe.scuola_id_scuola 
						AND studente_attends_classe.studente_id_studente = studente.id_studente 
						AND studente_attends_classe.classe_id_classe  = classe.id_classe 
						AND studente_attends_classe.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico 
						AND classe_has_stage.classe_id_classe = classe.id_classe 
						AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico;";
      $result = $MySQLConnection->query($queryStageId);
      $idStage = $result->fetch_assoc ();
      $idStage = $idStage ["stage_id_stage"];
      
      $queryValutazioneId = "SELECT id_valutazione_stage 
								FROM valutazione_stage 
								WHERE stage_id_stage = $idStage 
								AND studente_id_studente = " . $_SESSION['userId'] . ";";
      $result = $MySQLConnection->query($queryValutazioneId);
      if ($result->num_rows <= 0)
      {
        $Query = "INSERT INTO valutazione_stage (descrizione, voto, stage_id_stage, studente_id_studente) VALUES ('$Descrizione', '$Voto', '$idStage', '" . $_SESSION['userId'] . "')";
            
        if (!$MySQLConnection->query ( $Query )) {
			echo "invio della valutazione NON riuscito";                
        }
      }
      else
      {
	      $idValutazione = $result->fetch_assoc ();
	      $idValutazione = $idValutazione ['id_valutazione_stage'];
              
          $UpdateQuery = "UPDATE  `valutazione_stage` 
          					SET  `descrizione` =  '$Descrizione', 
          					`voto` =  '$Voto' 
          					WHERE  `valutazione_stage`.`id_valutazione_stage` = $idValutazione;";
          if ($MySQLConnection->query($UpdateQuery))
          {
              echo "invio della valutazione riuscito";
          }
          else
          {
                echo "Modifica della valutazione non riuscito";
          }
      }
    $MySQLConnection->close ();
?>