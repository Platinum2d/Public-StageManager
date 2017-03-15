<?php
    include "../../functions.php";
    $id_tutor = $_SESSION ['userId'];
    
    $email_destinatario = $_POST ['email'];
    $object = $_POST ['object'];
    $msg = $_POST ['message'];
    stripslashes ( $msg );
    stripslashes ( $object );
    
    if ($email_destinatario){
        $connection = dbConnection("../../../");
        $query = "SELECT tutor.nome, tutor.cognome, tutor.email
                    FROM tutor
                    WHERE tutor.id_tutor = $id_tutor;";
        $result = $connection->query ( $query );
        while ( $row = $result->fetch_assoc () ) {
            $nome = $row ['nome'];
            $cognome = $row ['cognome'];
            $email_tutor = $row ['email'];
        }
        
        $headers .= "From:" . $cognome . " " . $nome . "<" . $email_tutor .">";
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
    echo "<script> alert($email_destinatario + ' ' + $object + ' ' + $msg + ' ' + $headers) </script>";
    header ( "location: index.php" );
?>