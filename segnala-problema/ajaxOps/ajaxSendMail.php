<?php
include "../../pages/functions.php";
$connessione = dbConnection("../../");

$categoria = $_POST['categoria'];
$oggetto = $_POST['oggetto'];
$messaggio = $_POST['messaggio'];
$utente = $_SESSION ['user'];
$id_utente = $_SESSION ['userId'];
$tipoUtente = $_SESSION ['type'];

if ($tipoUtente == superUserType) {
    $tipoMail = "Super user";
    
    $query = "SELECT nome, cognome, email
    FROM super_user
    WHERE id_super_user = $id_utente;";
}
else if ($tipoUtente == ceoType) {
    $tipoMail = "Responsabile aziendale";
    
    $query = "SELECT nome_responsabile AS nome, cognome_responsabile AS cognome, email_responsabile AS email, nome_aziendale AS nome_azienda, email_aziendale AS email_azienda
    FROM azienda
    WHERE id_azienda = $id_utente;";
}
else if ($tipoUtente == aztutType) {
    $tipoMail = "Tutor aziendale";
    
    $query = "SELECT nome, cognome, email
    FROM tutor
    WHERE id_tutor = $id_utente;";
}
else if ($tipoUtente == scuolaType) {
    $tipoMail = "Responsabile scolastico";
    
    $query = "SELECT nome_responsabile AS nome, cognome_responsabile AS cognome, email_responsabile AS email, nome AS nome_scuola, email AS email_scuola
    FROM scuola
    WHERE id_scuola = $id_utente;";
}
else if ($tipoUtente == docrefType) {
    $tipoMail = "Docente referente";
    
    $query = "SELECT nome, cognome, email
    FROM docente
    WHERE id_docente = $id_utente;";
}
else if ($tipoUtente == doctutType) {
    $tipoMail = "Docente tutor";
    
    $query = "SELECT nome, cognome, email
    FROM docente
    WHERE id_docente = $id_utente;";
}
else if ($tipoUtente == studType) {
    $tipoMail = "Studente";
    
    $query = "SELECT nome, cognome, email
    FROM studente
    WHERE id_studente = $id_utente;";
}

$result = $connessione->query($query);
if (!$result || $result->num_rows === 0) {
    echo "non esiste il mittente";
}
else {
    
    $row = $result->fetch_assoc ();
    if (isset ($row ['nome']) && isset ($row ['cognome']) && $row ['nome'] != "" && $row ['cognome'] != "") {
        $nome = $row ['nome'] . " " . $row ['cognome'];
    }
    else if (isset ($row ['nome_scuola'])) {
        $nome = $row ['nome_scuola'];
    }
    else if (isset ($row ['nome_azienda'])) {
        $nome = $row ['nome_azienda'];
    }
    else {
        $nome = "";
    }
    
    if (isset ($row ['email']) && $row ['email'] != "") {
        $mittente = $row ['email'];
    }
    else if (isset ($row ['email_azienda'])) {
        $mittente = $row ['email_azienda'];
    }
    else if (isset ($row ['email_scuola'])) {
        $mittente = $row ['email_scuola'];
    }
    else {
        $mittente = "";
    }
    
    $headers = "From:" . $nome;
    if ($mittente != "") {
        $headers .= "<" . $mittente . ">";
    }
    $oggettoMail = "Mail di segnalazione di un problema da $nome";
    $messaggioMail = "Categoria: " . $categoria . ".\n" .
            "Tipo utente mittente: " . $tipoMail . ".\n" .
            "User id mittente: " . $id_utente . ".\n" .
            "Mittente: " . $nome . " <" . $mittente . ">" . ".\n" .
            "Oggetto: " . $oggetto . ".\n\n" .
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
}
?>