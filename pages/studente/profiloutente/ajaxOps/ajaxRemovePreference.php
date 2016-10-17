<?php
    include "../../../functions.php";
    
    $pref = $_POST['preferenza'];
    $query = "DELETE FROM studente_whises_figura_professionale ".
		    "WHERE figura_professionale_id_figura_professionale = ".
		    "(SELECT id_figura_professionale FROM figura_professionale WHERE nome = '$pref')".
		    "AND studente_id_studente = ".$_SESSION['userId'];
    $conn = dbConnection("../../../../");
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    if ($conn->query($query)) echo "ok"; else echo $conn->error;
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    
    
    