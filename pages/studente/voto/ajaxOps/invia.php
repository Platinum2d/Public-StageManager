<?php
    include '../../../functions.php';
    checkLogin ( studType,"../../../../" );
    $MySQLConnection = dbConnection("../../../../");
    
    $Voto = htmlspecialchars ( $_POST ['voto'] );
    $Descrizione = htmlspecialchars ( $_POST ['descrizione'] );
    $idStudenteHasStage = $_SESSION ['studenteHasStageId'];
        
    $Voto = stripslashes ( $Voto );
    $Descrizione = stripslashes ( $Descrizione );
        
    $Voto = $MySQLConnection->escape_string ( $Voto );
    $Descrizione = $MySQLConnection->escape_string ( $Descrizione );        
        
    if ($MySQLConnection->connect_error) 
    {
        echo "no ok";
    }
      
      $queryValutazioneId = "SELECT studente_has_stage.valutazione_stage_id_valutazione_stage 
								FROM studente_has_stage 
								WHERE studente_has_stage.id_studente_has_stage = $idStudenteHasStage 
								AND studente_has_stage.valutazione_stage_id_valutazione_stage IS NOT NULL;";
      $result = $MySQLConnection->query($queryValutazioneId);
      if ($result->num_rows <= 0)
      {
        $Query = "INSERT INTO valutazione_stage (descrizione, voto) 
        			VALUES ('$Descrizione', '$Voto');";
            
        if (!$MySQLConnection->query ( $Query )) {
			echo "no ok";                
        }
        else {
        	$idNuovaValutazioneStage = $MySQLConnection->insert_id;
        	$Query = "UPDATE `studente_has_stage` 
          					SET `valutazione_stage_id_valutazione_stage` =  '$idNuovaValutazioneStage' 
          					WHERE `id_studente_has_stage` = $idStudenteHasStage;";
        	if (!$MySQLConnection->query ( $Query )) {
        		echo "no ok";
        	}
        	else {
        		echo "ok";
        	}
        }
      }
      else
      {
	      $idValutazione = $result->fetch_assoc ();
	      $idValutazione = $idValutazione ['valutazione_stage_id_valutazione_stage'];
              
          $UpdateQuery = "UPDATE  `valutazione_stage` 
          					SET  `descrizione` =  '$Descrizione', 
          					`voto` =  '$Voto' 
          					WHERE  `valutazione_stage`.`id_valutazione_stage` = $idValutazione;";
          if ($MySQLConnection->query($UpdateQuery))
          {
              echo "ok";
          }
          else
          {
                echo "no ok";
          }
      }
    $MySQLConnection->close ();
?>