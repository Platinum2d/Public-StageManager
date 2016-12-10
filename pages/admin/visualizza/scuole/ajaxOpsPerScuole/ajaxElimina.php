<?php
    include '../../../../functions.php';
    
    $connessione = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    
    $query = "DELETE FROM scuola WHERE id_scuola = $id";
    
    if ($connessione->query($query))
        echo "ok";
    else 
        echo $connessione->errno;