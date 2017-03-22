<?php
    include "../../../functions.php";
    $id_scuola = $_SESSION ['userId'];
    
    $connection = dbConnection("../../../../");
    $query = "SELECT scuola.nome, scuola.email
                FROM scuola
                WHERE scuola.id_scuola = $id_scuola;";
    $result = $connection->query ( $query );
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc ();
        $nome = $row ['nome'];
        if (isset ($row ['cognome'])) {
            $nome .= " " . $row ['cognome'];
        }
        $mittente = $row ['email'];
    }

    if (isset ($_POST ['email'])) {
        $destinatario = $_POST ['email'];
        $headers .= "From:" . $nome . "<" . $mittente .">";
    }
    else {
        $destinatario = $mittente;
        $headers .= "From: <noreply@stagemanager.it>";
    }    
    $oggetto = $_POST ['object'];
    $messaggio = $_POST ['message'];
    
    if (mail ( $destinatario, $oggetto, $messaggio, $headers )) {
        echo "ok";
         
    } else {
        echo "error";
    }
?>