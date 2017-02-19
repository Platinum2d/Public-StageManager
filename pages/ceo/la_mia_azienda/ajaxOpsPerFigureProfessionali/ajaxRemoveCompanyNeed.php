<?php
    include '../../../functions.php';
    $connection = dbConnection("../../../../");
    $errore = false;
    
    $figura = strip_tags($connection->escape_string($_POST['figura']));
    $idfigura = $connection->query("SELECT id_figura_professionale AS id FROM figura_professionale WHERE nome = '$figura'")->fetch_assoc()['id'];
    
    $query = "DELETE FROM azienda_needs_figura_professionale WHERE azienda_id_azienda = ".$_SESSION['userId']." AND figura_professionale_id_figura_professionale = ".$idfigura;
    $cleanquery = "DELETE FROM figura_professionale WHERE id_figura_professionale = $idfigura";
    
    if ($connection->query($query))
    {
        $numcomp = intval($connection->query("SELECT COUNT(*) AS c FROM azienda_needs_figura_professionale WHERE figura_professionale_id_figura_professionale = $idfigura")->fetch_assoc()['c']);
        if ($numcomp === 0) 
            $errore = $connection->query($cleanquery) ? false : true;
    }
    else
        $errore = true;
    
    if ($errore) 
        echo $connection->error;
    else 
        echo "ok";