<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$idspec = $_POST['id'];


if($result = $connessione->query("SELECT nome FROM preferenza WHERE id_preferenza = $idspec"))
{
    $row = $result->fetch_assoc();
    echo $row['nome'];    
}