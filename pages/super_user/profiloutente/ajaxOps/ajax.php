<?php
    include '../../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../../");
        $id_docente = $_SESSION ['userId'];
        $username = $connessione->escape_string ( strip_tags(strip_whitespaces(trim($_POST ['username']))));
        $nome = $connessione->escape_string ( strip_tags(trim($_POST ['first'])));
        $cognome = $connessione->escape_string ( strip_tags(trim($_POST ['last'])) );
        $email = $connessione->escape_string ( strip_tags(trim($_POST ['mail'])) );
        $telefono = $connessione->escape_string ( strip_tags(trim($_POST ['phone'])) );
        
        $telefono = (isset($telefono) && !empty($telefono)) ? "'".$telefono."'" : "NULL";
        $email = (isset($email) && !empty($email)) ? "'".$email."'" : "NULL";
        
        $userquery = "UPDATE utente 
                        SET username = '$username' 
                        WHERE id_utente = $id_docente";
        $sql = "UPDATE super_user 
                SET nome = '$nome', cognome = '$cognome', email = $email, telefono = $telefono 
                WHERE id_super_user=$id_docente;";
        if ($connessione->query ( $userquery ) && $connessione->query ( $sql ))
            echo "ok";
        else 
            echo $connessione->error;
    }
?>