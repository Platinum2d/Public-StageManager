<?php
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
        
    $iddocente = $_POST['iddocente'];
    $error = false;
    
    $query = "DELETE FROM docente WHERE id_docente = $iddocente";
    if (!$conn->query($query)){ $error =  true; }
    else
    {
        $query = "DELETE FROM utente WHERE id_utente = $iddocente";
        if (!$conn->query($query)){ $error =  true; }
    }
    
    if ($error)
        echo "Errore: query non riuscita o dipendenze esterne non risolte.\nControllare che tutte le entità legate a questo docente siano state eliminate o modificate opportunamente";
    else
        echo "ok";