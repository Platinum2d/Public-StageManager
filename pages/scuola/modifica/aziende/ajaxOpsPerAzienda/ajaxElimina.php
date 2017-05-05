<?php
    
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");
        
    $idazienda = $_POST['idazienda'];
    $permesso_registro = ($_POST['deleteRegistro'] === "true") ? "1" : "0";
    $permesso_note = ($_POST['deleteNote'] === "true") ? "1" : "0";
    $permesso_valutazione_studente = ($_POST['deleteValutazioneStudente'] === "true") ? "1" : "0";
    $permesso_valutazione_stage = ($_POST['deleteValutazioneStage']) ? "1" : "0";
    
    $errore = false;
    
    $lavoro_giornaliero_query = "DELETE FROM lavoro_giornaliero WHERE studente_has_stage_id_studente_has_stage IN (SELECT id_studente_has_stage 
                                                                                                                   FROM studente_has_stage 
                                                                                                                   WHERE azienda_id_azienda = $idazienda)";
    
    $note_docenti_query = "DELETE FROM registro_note_azienda WHERE azienda_id_azienda = $idazienda";
    
    $studente_has_stage_query = "UPDATE studente_has_stage SET tutor_id_tutor = NULL, azienda_id_azienda = NULL";
    $studente_has_stage_query .= " WHERE azienda_id_azienda = $idazienda";
    
    if ($permesso_registro === "1")
        if (!$conn->query($lavoro_giornaliero_query)) $errore = true;
        
    if ($permesso_valutazione_studente === "1")
    {
        $valutazione_studente_query = "DELETE FROM risposta_voce_modulo_studente WHERE studente_has_stage IN (SELECT id_studente_has_stage "
                                                                                                           . "FROM studente_has_stage "
                                                                                                           . "WHERE azienda_id_azienda = $idazienda)";
        
        $conn->query($valutazione_studente_query);
    }
        
    if ($permesso_valutazione_stage === "1")
    {
        $valutazione_stage_query = "DELETE FROM risposta_voce_modulo_stage WHERE studente_has_stage IN (SELECT id_studente_has_stage "
                                                                                                           . "FROM studente_has_stage "
                                                                                                           . "WHERE azienda_id_azienda = $idazienda)";
        
        $conn->query($valutazione_stage_query);
    }
        
    if ($permesso_note === "1")
        if (!$conn->query($note_docenti_query)) $errore = true;
        
    if (!$conn->query($studente_has_stage_query)) $errore = true;
    
    $fetch_tutor = "SELECT id_tutor FROM tutor WHERE azienda_id_azienda = $idazienda";
    $result_fetch = $conn->query($fetch_tutor);
    if (is_object($result_fetch) && $result_fetch->num_rows > 0)
    {
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
        while ($row = $result_fetch->fetch_assoc())
        {
            $id = $row['id_tutor'];
            $tutor_query = "DELETE FROM tutor WHERE id_tutor = $id";
            $utente_tutor_query = "DELETE FROM utente WHERE id_utente = $id";

            $immagine_fetch = "SELECT id_immagine_profilo, URL FROM immagine_profilo, utente WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo AND id_utente = $id";
            $result = $conn->query($immagine_fetch);
            if (is_object($result) && $result->num_rows > 0) 
            {
                $result = $result->fetch_assoc();
                $id_immagine = $result['id_immagine_profilo'];
                $url = $result['URL'];

                $immagine_query = "DELETE FROM immagine_profilo WHERE id_immagine_profilo = $id_immagine";
                if (!$conn->query($immagine_query)) $errore = true;

                if (isset($url) && !empty($url) && intval($conn->query("SELECT COUNT(id_immagine_profilo) AS count FROM immagine_profilo WHERE URL = '$url'")->fetch_assoc()['count']) === 0)
                    unlink("../../../../../media/loads/profimgs/$url");
            }

            if (!$conn->query($tutor_query) || !$conn->query($utente_tutor_query)) $errore = true; 
        }
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    }
    
    
    $immagine_fetch = "SELECT id_immagine_profilo, URL FROM immagine_profilo, utente WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo AND id_utente = $idazienda";
    $result = $conn->query($immagine_fetch);
    if (is_object($result) && $result->num_rows > 0) 
    {
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $result = $result->fetch_assoc();
        $id_immagine = $result['id_immagine_profilo'];
        $url = $result['URL'];
        
        $immagine_query = "DELETE FROM immagine_profilo WHERE id_immagine_profilo = $id_immagine";
        if (!$conn->query($immagine_query)) $errore = true;
        
        if (intval($conn->query("SELECT COUNT(id_immagine_profilo) AS count FROM immagine_profilo WHERE URL = '$url'")->fetch_assoc()['count']) === 0)
            unlink("../../../../../media/loads/profimgs/$url");
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    }
    
    $azienda_query = "DELETE FROM azienda WHERE id_azienda = $idazienda";
    $utente_azienda_query = "DELETE FROM utente WHERE id_utente = $idazienda";
    
    $azienda_needs_figura_professionale_query = "DELETE FROM azienda_needs_figura_professionale WHERE azienda_id_azienda = $idazienda";
    
    $segnalazioni_query = "UPDATE segnala_problema SET utente_id_utente = NULL WHERE utente_id_utente = $idazienda";
    
    if (!$conn->query($segnalazioni_query) && !$conn->query($azienda_needs_figura_professionale_query) || !$conn->query($azienda_query) || !$conn->query($utente_azienda_query)) $errore = true;
    
    if($errore)
        echo $conn->error;
    else
        echo "ok";
    
?>