<?php
    include "../../../../functions.php";
    
    $conn = dbConnection("../../../../../"); //??
    
    $id = $_POST['id'];
    $nome = trim($conn->escape_string(strip_tags($_POST['nome'])));
    
    $query = "UPDATE figura_professionale SET nome = '$nome' WHERE id_figura_professionale = $id";
    
    if($conn->query($query))
        echo "ok";
    else
        echo $conn->error;