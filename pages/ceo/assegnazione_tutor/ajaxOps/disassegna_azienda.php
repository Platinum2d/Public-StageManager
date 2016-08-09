<?php
    include '../../../functions.php';   
    $uid = intval ( $_POST ['uid'] );
    $db = dbConnection("../../../../");
    $q_studenti = $db->query ( "Update studente set tutor_id_tutor = NULL WHERE id_studente = $uid" );
?>