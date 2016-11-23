<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
        
    $iddocente = $_POST['iddocente'];
        
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    $query = "DELETE FROM utente WHERE id_utente = $iddocente";
    $conn->query($query);
    $query = "DELETE FROM docente WHERE id_docente = $iddocente";
    $conn->query($query);
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
?>