<?php
    include "../../../pages/functions.php";
    
    $conn = dbConnection("../../../");
    $email = $_POST['mail'];
    
    $query = "SELECT nome, cognome, id_docente
                FROM docente
                WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $id_utente = $row ['id_docente'];
        $nome = $row ['nome'] . " " . $row ['cognome'];
    }
    else
    {
        $query = "SELECT nome, cognome, id_studente
                    FROM studente
                    WHERE email = '$email'";
        $result = $conn->query($query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $id_utente = $row ['id_studente'];
            $nome = $row ['nome'] . " " . $row ['cognome'];
        }
        else
        {
            $query = "SELECT nome, cognome, id_tutor
                        FROM tutor
                        WHERE email = '$email'";
            $result = $conn->query($query);
            if ($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $id_utente = $row ['id_tutor'];
                $nome = $row ['nome'] . " " . $row ['cognome'];
            }
            else
            {
                $query = "SELECT nome_responsabile, cognome_responsabile, id_azienda
                FROM azienda
                WHERE email_aziendale = '$email'
                OR email_responsabile = '$email';";
                $result = $conn->query($query);
                if ($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $id_utente = $row ['id_azienda'];
                    $nome = $row ['nome_responsabile'] . " " . $row ['cognome_responsabile'];
                }
                else
                {
                    $query = "SELECT nome, id_scuola
                    FROM scuola
                    WHERE email = '$email'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0)
                    {
                        $row = $result->fetch_assoc();
                        $id_utente = $row ['id_scuola'];
                        $nome = $row ['nome'];
                    }
                }
            }
        }
    }
    
    if (isset ($id_utente)) {
        $stato = false;
        $codice = generateRandomString(32);
        $query = "SELECT username, recupera_password_id_recupera_password
        FROM utente
        WHERE id_utente = '$id_utente'";
        $result = $conn->query($query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $username = $row ['username'];
            if (isset ($row ['recupera_password_id_recupera_password'])) {
                $id_recupera = $row ['recupera_password_id_recupera_password'];
            }
    
            if (isset ($id_recupera)) {
                $query = "UPDATE recupera_password 
                            SET codice_email = '$codice' 
                            WHERE id_recupera_password = $id_recupera;";
                if ($result = $conn->query($query))
                {
                    $stato = true;
                }
            }
            else {
                $query = "INSERT INTO recupera_password (codice_email) 
                            VALUES ('$codice')";
                if ($result = $conn->query($query))
                {
                    $id_recupera = $conn->insert_id;
                    $query = "UPDATE utente
                                SET recupera_password_id_recupera_password = $id_recupera 
                                WHERE id_utente = $id_utente;";
                    if ($result = $conn->query($query))
                    {
                        $stato = true;
                    }
                }
            }
        }
        
        if ($stato) {
            $messaggio = "SI PREGA DI NON RISPONDERE ALLA MAIL CHE SEGUE, GRAZIE\n\n" .
                            "Salve, $username.\n" .
                            "Se ha ricevuto questa mail, significa che sta tentando di ripristinare la password " .
                            "del suo profilo nel portale www.stagemanager.it.\n" .
                            "In caso contrario, la preghiamo di ignorare questo messaggio.\n\n" .
                            "Clicchi sul seguente link per proseguire con il ripristino: ".
                            "http://www.stagemanager.it/sessione/reimposta-password/index.php?user=$username&code=$codice";
            $mittente = "noreply@stagemanager.it";
            $headers = "From: ".$mittente;   
            $oggetto = "Recupero password per $nome";
            if (mail($email, $oggetto, $messaggio, $headers)) {
                echo 0; //tutto ok
            }
            else {
                echo 3; //mail non inviata
            }
        }
        else {
            echo 2; //errore nelle query
        }
    }
    else {
        echo 1; //email non corretta
    }
?>