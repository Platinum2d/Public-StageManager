<?php
    include '../../../pages/functions.php';
    $conn = dbConnection("../../../");
        
    $id = $_POST['id'];
    $nuovapassword = md5($_POST['password']);
        
    $query = "UPDATE utente 
                SET password = '$nuovapassword' 
                WHERE id_utente = $id";
    if ($conn->query($query))
    {
        $query = "SELECT recupera_password_id_recupera_password
                    FROM utente
                    WHERE id_utente = $id";
        $result = $conn->query($query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc ();
            $id_recupera = $row ['recupera_password_id_recupera_password'];
            $query = "UPDATE recupera_password
                        SET codice_email = NULL
                        WHERE id_recupera_password = $id_recupera";
            if ($conn->query($query))
            {
                echo 0; //tutto ok
            }
            else {
                echo 1; //problema query
            }
        }
        else {
            echo 1; //problema query
        }
    }
    else {
        echo 1; //problema query
    }
?>