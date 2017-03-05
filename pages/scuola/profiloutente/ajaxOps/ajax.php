<?php
    include '../../../functions.php';
    if ($_POST ['first']) {
        $connessione = dbConnection ("../../../../");
        $id_scuola = $_SESSION ['userId'];
        $nome = $connessione->escape_string ( strip_tags($_POST ['first']));
        $email = $connessione->escape_string ( strip_tags($_POST ['mail']) );
        $telefono = $connessione->escape_string ( strip_tags($_POST ['phone']) );
        $sql = "UPDATE scuola SET nome='$nome', telefono='$telefono', email='$email' WHERE id_scuola='$id_scuola'";
        if ($connessione->query ( $sql ))
            echo "ok";
        else 
            echo $connessione->error;
    }
?>