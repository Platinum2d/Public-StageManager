<?php
    include '../../../functions.php';
    $connection = dbConnection("../../../../");
    $existsError = 1062;
    $errore = false;
    
    $nome = strip_tags($connection->escape_string($_POST['nome']));
    
    $query = "INSERT INTO figura_professionale (nome) VALUES ('$nome')";
    
    if ($connection->query($query)) $errore = false;
    else
    {
        if ($connection->errno === $existsError) $errore = false;
        else $errore = true;
    }
    
    $figureid = $connection->query("SELECT id_figura_professionale FROM figura_professionale WHERE nome = '$nome'")->fetch_assoc()['id_figura_professionale'];
    
    $query = "INSERT INTO azienda_needs_figura_professionale (figura_professionale_id_figura_professionale, azienda_id_azienda) VALUES ($figureid, ".$_SESSION['userId'].")";
    
    if ($connection->query($query)) $errore = false;
    else
    {
        if ($connection->errno === $existsError) $errore = false;
        else $errore = true;
    }
    
    if ($errore) echo "errore"; else echo "ok";