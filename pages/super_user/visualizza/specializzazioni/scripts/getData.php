<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$idspec = $_POST['id'];


if($result = $connessione->query("SELECT nome FROM specializzazione WHERE id_specializzazione = $idspec"))
{
    $row = $result->fetch_assoc();
    echo $row['nome'];    
}