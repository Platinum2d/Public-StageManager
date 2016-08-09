<?php
    include '../../../functions.php';
    $connessione = dbConnection("../../../../");    
    $uid = $_POST ['uid'];
    $aid = $_POST ['aid'];
    $query = "UPDATE studente SET `tutor_id_tutor`=$aid where `id_studente`=$uid";
    $result1 = $connessione->query ( $query );
?>