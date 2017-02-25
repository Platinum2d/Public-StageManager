<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$id = $_POST['id'];
$nome = $connessione->escape_string($_POST['nome']);

$Query = "UPDATE `preferenza` SET `nome` = '$nome' WHERE `id_preferenza` = $id; ";

if ($connessione->query($Query))
{
    echo $nome;
}
else
{
    echo "errore";
}