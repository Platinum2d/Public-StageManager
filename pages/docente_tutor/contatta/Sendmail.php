<?php
    include "../../functions.php";
    $id_docente = $_SESSION ['userId'];
    checkLogin(doctutType , "../../../");
    $email_destinatario = $_POST ['email'];
    $object = $_POST ['object'];
    $msg = $_POST ['message'];
    stripslashes ( $msg );
    stripslashes ( $object );
    
    if ($email_destinatario)
    {
        $connection = dbConnection("../../../");
        $query = "SELECT docente.nome, docente.cognome, docente.email
                    FROM docente
                    WHERE docente.id_docente = $id_docente;";
        $result = $connection->query ( $query );
        while ( $row = $result->fetch_assoc () ) {
            $nome = $row ['nome'];
            $cognome = $row ['cognome'];
            $email_docente = $row ['email'];
        }
        
        $headers .= "From:" . $cognome . " " . $nome . "<" . $email_docente .">";
        if (mail ( $email_destinatario, $object, $msg, $headers )) {
            $_SESSION ['email_sent'] = sent;
        } else {
            $_SESSION ['email_sent'] = notSent;
        }
    }
    else{
        $_SESSION ['email_sent'] = notSent;
    }
    // Da inserire l'url della home page o un redirect automatico.
    header ( "location: index.php" );
?>