<?php
        include "../../../functions.php";
    
        $pref = $_POST['preferenza'];
        $conn = dbConnection("../../../../");
        $query = "INSERT INTO studente_has_preferenza (studente_id_studente, preferenza_id_preferenza) VALUES (".$_SESSION['userId'].",$pref)";
        if($conn->query($query)) echo "ok"; else echo $conn->error;