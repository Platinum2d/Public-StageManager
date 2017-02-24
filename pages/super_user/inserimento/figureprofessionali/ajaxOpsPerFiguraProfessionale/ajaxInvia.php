<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $figuraprofessionale = $connection->escape_string($_POST['nome']);
    
    $query = "INSERT INTO figura_professionale (nome) VALUES ('$figuraprofessionale')";
    $ok = ($connection->query($query)) ? true : false;
    
    if ($ok) echo "ok"; else echo $connection->error;
?>