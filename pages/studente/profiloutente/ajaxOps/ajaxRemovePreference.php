<?php
    include "../../../functions.php";
    
    $pref = $_POST['preferenza'];
    $query = "DELETE FROM studente_has_preferenza WHERE preferenza_id_preferenza = (SELECT id_preferenza FROM preferenza WHERE nome = '$pref') AND studente_id_studente = ".$_SESSION['userId']."";
    $conn = dbConnection("../../../../");
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    if ($conn->query($query)) echo "ok"; else echo $conn->error;
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    
    
    