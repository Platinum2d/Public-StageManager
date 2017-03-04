<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $oldid = $conn->query("SELECT immagine_profilo_id_immagine_profilo AS id_immagine FROM utente WHERE id_utente = ".$_SESSION['userId'])->fetch_assoc()['id_immagine'];
    $query = "UPDATE utente SET immagine_profilo_id_immagine_profilo = NULL WHERE immagine_profilo_id_immagine_profilo = $oldid";
    if ($conn->query($query)) {
        echo "ok";
    }
    else {
        echo $conn->error;
    }
?>