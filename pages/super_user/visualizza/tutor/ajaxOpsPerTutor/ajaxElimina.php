<?php
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");
    $id = $_POST['idtutor'];
    
    $error = false;
    
    $query = "DELETE FROM tutor WHERE id_tutor = $id";
    if (!$conn->query($query)){ $error =  true; }
    else
    {
        $query = "DELETE FROM utente WHERE id_utente = $id";
        if (!$conn->query($query)){ $error =  true; }
    }
    
    if ($error)
        echo "Errore: query non riuscita o dipendenze esterne non risolte.\nControllare che tutte le entità legate a questo tutor siano state eliminate o modificate opportunamente";
    else
        echo "ok";
?>