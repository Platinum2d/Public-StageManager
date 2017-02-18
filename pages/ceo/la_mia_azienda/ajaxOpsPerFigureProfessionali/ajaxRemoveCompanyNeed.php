<?php
    include '../../../functions.php';
    $connection = dbConnection("../../../../");
    
    $figura = strip_tags($connection->escape_string($_POST['figura']));
    $idfigura = $connection->query("SELECT id_figura_professionale AS id FROM figura_professionale WHERE nome = '$figura'")->fetch_assoc()['id'];
    
    $query = "DELETE FROM azienda_needs_figura_professionale WHERE azienda_id_azienda = ".$_SESSION['userId']." AND figura_professionale_id_figura_professionale = ".$idfigura;
    if ($connection->query($query))
        echo "ok";
    else
        echo $connection->error;