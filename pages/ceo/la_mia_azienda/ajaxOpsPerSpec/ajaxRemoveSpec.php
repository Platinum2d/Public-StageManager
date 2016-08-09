<?php
    include "../../../functions.php";
    
    $spec = $_POST['specializzazione'];
    $query = "DELETE FROM `azienda_has_specializzazione` WHERE `specializzazione_id_specializzazione` = (SELECT `id_specializzazione` FROM `specializzazione` WHERE `nome` = '$spec')"
            . " AND `azienda_id_azienda` = ".$_SESSION['userId']."";
    $conn = dbConnection("../../../../");
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    if ($conn->query($query)) echo "ok"; else echo $conn->error;
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    
    
    