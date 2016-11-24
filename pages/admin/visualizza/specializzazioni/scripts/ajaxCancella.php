<?php

include '../../../../functions.php';
$connessione = dbConnection("../../../../../");
$id = $_POST['id'];

$Query = "DELETE FROM `specializzazione` WHERE `id_specializzazione` = $id; ";

if ($connessione->query($Query))
{
    echo "tutto ok";
}
else
{
    $connessione->query("SET FOREIGN_KEY_CHECKS = 0");
    $connessione->query($Query);
    $connessione->query("SET FOREIGN_KEY_CHECKS = 1");
}

