<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$id = $_POST['id'];
$nome = $connessione->escape_string($_POST['nome']);
$spec = $_POST['specializzazione'];

$Query = "UPDATE `classe` SET `nome` = '$nome', `specializzazione_id_specializzazione` = $spec WHERE `id_classe` = $id; ";

if ($connessione->query($Query))
{
    echo $_POST['nome'];
}
else
{
    echo "errore";
}