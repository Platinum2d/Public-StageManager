<?php    
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    $username = $conn->escape_string($_POST['user']);
    $exception = (isset($_POST['exception']) && !empty($_POST['exception'])) ? $_POST['exception'] : null;
    
    $query = (isset($exception)) ? "SELECT * FROM utente WHERE username = '$username' AND username != '$exception'" : "SELECT * FROM utente WHERE username = '$username'";
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