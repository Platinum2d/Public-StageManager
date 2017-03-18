<?php
    
    include "../../../../../../functions.php";
    $conn = dbConnection("../../../../../../../");
    $username = $conn->escape_string($_POST['user']);
    $query = "SELECT id_utente FROM utente WHERE username = '$username'";
    $result = $conn->query($query);
    
    if ($result->num_rows === 0)
    {
        echo "nontrovato";
    }
    else
    {
        echo "trovato";
    }
?>