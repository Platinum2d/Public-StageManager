<?php
    include '../../../../functions.php';
            
    $connection = dbConnection("../../../../../");
        
    $preferenza = $connection->escape_string($_POST['nome']);
    
    $query = "SELECT id_preferenza FROM preferenza WHERE nome = '$preferenza'";
    $result = $connection->query($query);
    if ($result->num_rows > 0)
        echo "esiste";
    else 
        echo "non esiste";