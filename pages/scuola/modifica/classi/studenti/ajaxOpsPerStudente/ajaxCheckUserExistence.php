<?php
    
    include "../../../../../functions.php";
    $conn = dbConnection("../../../../../../");
    $username = $conn->escape_string(strip_whitespaces($_POST['user']));
    $original = $conn->escape_string(strip_whitespaces($_POST['original']));
    
    $query = "SELECT id_utente FROM utente WHERE username = '$username' AND username != '$original'";
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