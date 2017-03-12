<?php
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    $idneed = $_POST['id'];
//    
//    $figura = strip_tags($connection->escape_string($_POST['figura']));
//    $idfigura = $connection->query("SELECT figura_professionale_id_figura_professionale AS id FROM azienda_needs_figura_professionale AS anfp"
//                                . " WHERE anfp.id_azienda_needs_figura_professionale = $idneed")->fetch_assoc()['id'];
    
    $query = "DELETE FROM azienda_needs_figura_professionale WHERE id_azienda_needs_figura_professionale = $idneed";
    
    if ($connection->query($query))
        echo "ok";
    else
        echo $connection->error;
        