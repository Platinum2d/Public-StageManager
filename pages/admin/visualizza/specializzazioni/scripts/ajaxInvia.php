<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$id = $_POST['id'];
$nome = $connessione->escape_string($_POST['nome']);

$Query = "UPDATE `specializzazione` SET `nome` = '$nome' WHERE `specializzazione`.`id_specializzazione` = $id; ";

if ($connessione->query($Query))
{
    echo $nome;
}
else
{
    echo "errore";
}