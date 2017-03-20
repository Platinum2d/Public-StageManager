<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idStudente = $_SESSION['userId'];
    $idPreferenza = $_POST ['preferenza'];
    
    $query = "UPDATE studente_whises_figura_professionale
                SET preferenza_principale = 0
                WHERE studente_id_studente = $idStudente
                AND id_studente_whises_figura_professionale = $idPreferenza;";
    if($conn->query($query)) {
        echo "ok";
    }
    else {
        echo "non ok";
    }
?>