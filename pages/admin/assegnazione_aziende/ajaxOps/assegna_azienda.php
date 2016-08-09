<?php
    include '../../../functions.php';
    $connessione = dbConnection();    
    $uid = $_POST ['uid'];
    $aid = $_POST ['aid'];
        
    $query = "SET FOREIGN_KEY_CHECKS=0";
    $connessione->query ( $query );
        
    $query = "UPDATE studente SET `azienda_id_azienda`=$aid, `tutor_id_tutor` = NULL WHERE `id_studente`=$uid";
    if($connessione->query ( $query ))
        echo "ok";
    else
        echo "non ok";
        
    $query = "SET FOREIGN_KEY_CHECKS=1";
    $connessione->query ( $query );
?>