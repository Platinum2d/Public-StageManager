<?php
    include "../../pages/functions.php";
    $connessione = dbConnection("../../");

    $categoria = $_POST['categoria'];
    $oggetto = $_POST['oggetto'];
    $messaggio = $_POST['messaggio'];
    $utente = $_SESSION ['user'];
    $id_utente = $_SESSION ['userId'];
    $tipoUtente = $_SESSION ['type'];
    
    $headers = "From user: ".$utente.", user id: ".$id_utente.", user type:".$tipoUtente;
    $oggettoMail = "Mail di segnalazione di un problema";
    $messaggioMail = "Categoria: " . $categoria . ".<br>" .
                        "Oggetto: " . $oggetto . ".<br>" . 
                        "Messaggio: " . $messaggio;

    if (mail(EMAIL_DANIELE, $oggettoMail, $messaggioMail, $headers))
    {
        echo "email inviata con successo ad Daniele.\n";
    }
    else
    {
        echo "email non inviata ad Daniele.\n";
    }
    
    if (mail(EMAIL_ALESSIO, $oggettoMail, $messaggioMail, $headers))
    {
        echo "email inviata con successo ad Alessio.";
    }
    else
    {
        echo "email non inviata ad Alessio.";
    }
?>