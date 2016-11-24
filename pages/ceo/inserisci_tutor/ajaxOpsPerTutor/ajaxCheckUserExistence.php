<?php    
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    $username = $conn->escape_string($_POST['user']);
    $query = "SELECT * FROM studente WHERE username = '$username'";
    $result = $conn->query($query);
    
    if ($result->num_rows === 0)
    {
        $query = "SELECT * FROM docente WHERE username = '$username'";
        $result = $conn->query($query);
        if ($result->num_rows === 0)
        {
            $query = "SELECT * FROM tutor WHERE username = '$username'";
            $result = $conn->query($query);
            if ($result->num_rows === 0)
            {
                $query = "SELECT * FROM azienda WHERE username = '$username'";
                $result = $conn->query($query);
                if ($result->num_rows === 0)
                {
                    echo "nontrovato";
                }
                else
                {
                    echo "trovato";
                }
            }
            else
            {
                echo "trovato";
            }
        }
        else
        {
            echo "trovato";
        }
    }
    else
    {
        echo "trovato";
    }
?>