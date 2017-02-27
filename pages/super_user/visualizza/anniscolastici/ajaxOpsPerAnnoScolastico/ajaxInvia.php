<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    $nome = trim($conn->escape_string(strip_tags($_POST['nome'])));
    $corrente = ($_POST['corrente']) ? "1" : "0";
    
    if ($_POST['corrente']) $conn->query("UPDATE anno_scolastico SET corrente = 0");
    
    $query = "UPDATE anno_scolastico SET nome_anno = '$nome', corrente = $corrente WHERE id_anno_scolastico = $id";
    
    if($conn->query($query))
        echo "ok";
    else
        echo $conn->error;