<?php
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");
    $id = $_POST['idtutor'];
    $errore = false;
        
    $tutor_query = "DELETE FROM tutor WHERE id_tutor = $id";
    $utente_tutor_query = "DELETE FROM utente WHERE id_utente = $id";
    $studente_has_stage_query = "UPDATE studente_has_stage SET tutor_id_tutor = NULL WHERE tutor_id_tutor = $id";
    
    $immagine_fetch = "SELECT id_immagine_profilo, URL FROM immagine_profilo, utente WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo AND id_utente = $id";
    $result = $conn->query($immagine_fetch);   
    
    if (is_object($result) && $result->num_rows > 0) 
    {
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $result = $result->fetch_assoc();
        $id_immagine = $result['id_immagine_profilo'];
        $url = $result['URL'];

        $immagine_query = "DELETE FROM immagine_profilo WHERE id_immagine_profilo = $id_immagine";
        if (!$conn->query($immagine_query)) $errore = true;

        if (isset($url) && !empty($url) && intval($conn->query("SELECT COUNT(id_immagine_profilo) AS count FROM immagine_profilo WHERE URL = '$url'")->fetch_assoc()['count']) === 0)
            unlink("../../../../../media/loads/profimgs/$url");
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    if (!$conn->query($studente_has_stage_query) || !$conn->query($tutor_query) || !$conn->query($utente_tutor_query)) $errore = true; 
    
    if ($errore)
        echo $conn->error;
    else
        echo "ok";
?>