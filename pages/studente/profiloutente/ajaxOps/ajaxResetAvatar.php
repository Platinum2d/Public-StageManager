<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $oldid = $conn->query("SELECT immagine_profilo_id_immagine_profilo AS id_immagine FROM utente WHERE id_utente = ".$_SESSION['userId'])->fetch_assoc()['id_immagine'];
    $url = $conn->query("SELECT URL FROM immagine_profilo WHERE id_immagine_profilo = $oldid")->fetch_assoc()['URL'];
    
    $query = "UPDATE utente SET immagine_profilo_id_immagine_profilo = NULL WHERE immagine_profilo_id_immagine_profilo = $oldid";
    $deletequery = "DELETE FROM immagine_profilo WHERE id_immagine_profilo = $oldid";
    
    if ($conn->query($query) && $conn->query($deletequery))
    {
        if (intval($conn->query("SELECT COUNT(id_immagine_profilo) AS count FROM immagine_profilo WHERE URL = '$url'")->fetch_assoc()['count']) === 0)
            unlink("../../../../media/loads/profimgs/$url");
        
        echo "ok";
    }
    else
        echo $conn->error;