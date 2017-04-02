<?php
    include '../../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../../");
        $id_az = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( $_POST ['first'] );
        $citta = $connessione->escape_string ( $_POST ['city'] );
        $indirizzo = $connessione->escape_string ( $_POST ['address'] );
        $email = $connessione->escape_string ( $_POST ['mail'] );
        $telefono = $connessione->escape_string ( $_POST ['phone'] );
        $sito = $connessione->escape_string ( $_POST ['website'] );
        $cap = $connessione->escape_string ( $_POST ['cap'] );
        
        if ($citta == "") {
        	$citta = "NULL";
        }
        else {
        	$citta = "'".$citta."'";
        }
        if ($indirizzo == "") {
        	$indirizzo = "NULL";
        }
        else {
        	$indirizzo = "'".$indirizzo."'";
        }
        if ($email == "") {
        	$email = "NULL";
        }
        else {
        	$email = "'".$email."'";
        }
        if ($telefono == "") {
        	$telefono = "NULL";
        }
        else {
        	$telefono = "'".$telefono."'";
        }
        if ($sito == "") {
        	$sito = "NULL";
        }
        else {
        	$sito = "'".$sito."'";
        }
        if ($cap == "") {
        	$cap = "NULL";
        }
        else {
        	$cap = "'".$cap."'";
        }
        
        $sql = "UPDATE azienda 
        		SET nome_aziendale='$nome',citta_aziendale=$citta, indirizzo=$indirizzo, email_aziendale=$email, telefono_aziendale=$telefono, sito_web=$sito, cap=$cap 
        		WHERE id_azienda=$id_az;";
        
        if  ($connessione->query ( $sql )) {
        	echo "0";
        }
       	else {
       		echo "1";
       	}
    }
?>