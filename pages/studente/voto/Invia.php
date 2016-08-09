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
        
      $QueryNull = "SELECT valutazione_stage_id_valutazione_stage FROM studente WHERE valutazione_stage_id_valutazione_stage IS NULL AND id_studente = ".$_SESSION['userId'];
      $result = $MySQLConnection->query($QueryNull);
      if ($result->num_rows > 0)
      {
        $Query = "INSERT INTO valutazione_stage (voto, descrizione) VALUES ('$Voto', '$Descrizione')";
            
            
        if ($MySQLConnection->query ( $Query ) == TRUE) {
//            $_SESSION ['grade_sent'] = 2; // voto inviato correttamente
//                                         // echo "Dati inseriti correttamente.";
            echo "invio della valutazione riuscito";
            //header ( "location: " . prj_root . "/index.php" );
            $Query = "UPDATE studente SET valutazione_stage_id_valutazione_stage = 
                (SELECT MAX(id_valutazione_stage) FROM valutazione_stage) WHERE id_studente 
                = ".$_SESSION['userId'];
            $MySQLConnection->query ( $Query );
                
        }
        else
        {
//            $_SESSION ['grade_sent'] = 3; // errore invio query
//                                             // echo "Errore nell'invio della query: ". $Query . "<br>". $MySQLConnection->error;
            echo "invio della valutazione NON riuscito";
        }
      }
      else
      {
          $IdStudQuery = "SELECT valutazione_stage_id_valutazione_stage FROM studente WHERE id_studente = ".$_SESSION['userId'];
          $ris = $MySQLConnection->query($IdStudQuery);
          $row = $ris->fetch_assoc();
          $IdVal = $row['valutazione_stage_id_valutazione_stage'];
              
          $UpdateQuery = "UPDATE  `valutazione_stage` SET  `descrizione` =  '$Descrizione',
          `voto` =  '$Voto' WHERE  `valutazione_stage`.`id_valutazione_stage` = $IdVal;";
          if ($MySQLConnection->query($UpdateQuery))
          {
              echo "invio della valutazione riuscito";
          }
          else
          {
               echo $UpdateQuery;
          }
      }
    $MySQLConnection->close ();
?>