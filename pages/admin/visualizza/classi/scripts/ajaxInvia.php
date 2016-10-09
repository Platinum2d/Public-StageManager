<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$id = $_POST['id'];
$nome = $connessione->escape_string($_POST['nome']);

$Query = "UPDATE `classe` SET `nome` = '$nome' WHERE `id_classe` = $id; ";

if ($connessione->query($Query))
{
    echo $_POST['nome'];
}
else
{
    echo "errore";
}