<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $pref = $_POST['preferenza'];
    $query = "DELETE FROM studente_whises_figura_professionale ".
		    "WHERE id_studente_whises_figura_professionale = $pref;";
    if ($conn->query($query)) {
    	echo "ok";
    }
    else {
    	echo $conn->error;
    }
?>