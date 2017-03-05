<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $figuraprofessionale = $connection->escape_string($_POST['nome']);
    $settore = $_POST['settore'];
    
    $query = "INSERT INTO figura_professionale (nome) VALUES ('$figuraprofessionale')";
    $settorequery = "INSERT INTO settore_has_figura_professionale (settore_id_settore, figura_professionale_id_figura_professionale) VALUES ($settore, (SELECT MAX(id_figura_professionale) FROM figura_professionale))";
    
    $ok = ($connection->query($query) && $connection->query($settorequery)) ? true : false;
    
    if ($ok) echo "ok"; else echo $connection->error;
?>