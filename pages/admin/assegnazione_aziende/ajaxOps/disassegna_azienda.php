<?php
    include '../../../functions.php';   
    $uid = intval ( $_POST ['uid'] );
    $db = dbConnection();
    
    $query = "SET FOREIGN_KEY_CHECKS=0";
    $db->query ( $query );
    
    if($db->query ( "UPDATE `studente` SET `azienda_id_azienda` = NULL, `tutor_id_tutor` = NULL WHERE `id_studente` = $uid" ))
        echo "ok";
    else
        echo "non ok";
        
    $query = "SET FOREIGN_KEY_CHECKS=1";
    $db->query ( $query );
    ?>