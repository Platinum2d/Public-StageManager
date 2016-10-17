<?php
        include "../../../functions.php";
    
        $pref = $_POST['preferenza'];
        $conn = dbConnection("../../../../");
        $query = "INSERT INTO studente_whises_figura_professionale (studente_id_studente, figura_professionale_id_figura_professionale) VALUES (".$_SESSION['userId'].",$pref)";
        if($conn->query($query)) echo "ok"; else echo $conn->error;