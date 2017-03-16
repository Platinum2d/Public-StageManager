<?php
    include '../../../../functions.php';
    
    $conn = dbConnection("../../../../../");
    
    $id_shs = $_POST['id'];
    $error = false;
    
    $query = "DELETE FROM scuola WHERE id_scuola = $id_shs";
    if (!$conn->query($query)){ $error =  true; }
    else
    {
        $query = "DELETE FROM utente WHERE id_utente = $id_shs";
        if (!$conn->query($query)){ $error =  true; }
    }
    
    if ($error)
        echo "Errore: query non riuscita o dipendenze esterne non risolte.\nControllare che tutte le entità legate a questa scuola siano state eliminate o modificate opportunamente";
    else
        echo "ok";