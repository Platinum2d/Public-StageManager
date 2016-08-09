<?php
    include '../../functions.php';
    if ($_POST ['first']) 
    {
        $connessione = dbConnection ("../../../");
        $id_studente = $_SESSION ['userId'];
        $nome =  $connessione->escape_string( $_POST ['first'] );
        $cognome = $connessione->escape_string ( $_POST ['last'] );
        $citta =  $connessione->escape_string( $_POST ['city'] );
        $email =  $connessione->escape_string( $_POST ['mail'] );
        $telefono =  $connessione->escape_string( $_POST ['phone'] );
        $sql = "update studente set nome='$nome',cognome='$cognome', citta='$citta', email='$email', telefono='$telefono' where id_studente='$id_studente';";
        $result = $connessione->query ( $sql );
//	$query = "SELECT * FROM studente_has_preferenza WHERE studente_id_studente = ".$_SESSION['userId'];
//	$result = $connessione->query($query);
//	if($result->num_rows !== 0 ) 
//         {
//            $queryPref = "SELECT id_preferenza FROM preferenza WHERE nome = '$preferenza'";
//            $result = $connessione->query ($queryPref);
//            $row = $result->fetch_assoc();
//            $idpref = $row['id_preferenza'];
//                        
//            $query = "UPDATE `studente_has_preferenza` SET `preferenza_id_preferenza` = '$idpref' WHERE `studente_has_preferenza`.`studente_id_studente` = ".$_SESSION['userId'];
//            $connessione->query ($query);		
//	}
//	else 
//        {
////            $sql = "update studente set nome='$nome',cognome='$cognome', citta='$citta', email='$email', telefono='$telefono' where id_studente='$id_studente';";
////            $result = $connessione->query ($sql);
//            $queryIdPreferenza = "SELECT id_preferenza FROM preferenza WHERE nome = '$preferenza'";
//            $result = $connessione->query($queryIdPreferenza);  
//            
//            $row = $result->fetch_assoc();
//            $idPref = $row['id_preferenza'];
//            
//            $query = "INSERT INTO `studente_has_preferenza` (`studente_id_studente`, `preferenza_id_preferenza`) VALUES ('".$_SESSION['userId']."', '$idPref');";
//            $connessione->query($query);
//        }
    }
?>