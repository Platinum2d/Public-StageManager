<?php

include "../../functions.php";
$connessione = dbConnection("../../../../");



$destinatario = $_POST['destinatario'];
$oggetto = $_POST['oggetto'];
$messaggio = $_POST['messaggio'];
$mittente = '';
$nome = '';
$cognome = '';

$Query = "SELECT nome,cognome,email FROM studente WHERE id_studente = ".$_SESSION['userId'];
$result = $connessione->query($Query);
if ($result->num_rows > 0) 
{ 
    $row = $result->fetch_assoc(); 
    $mittente = $row['email'];   
    $nome = $row['nome'];
    $cognome = $row['cognome'];
}

$headers .= "From: ".$mittente;

if (mail($destinatario, $oggetto, $messaggio,$headers))
{
    echo "email inviata con successo";
}
else
{
    echo "email non inviata";
}