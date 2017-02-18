<?php
    
    include "../../../../functions.php";
        
    $conn = dbConnection("../../../../../");
        
    $idazienda = $_POST['idazienda'];
        
    $error = false;
    $query = "DELETE FROM `azienda` WHERE `id_azienda` = $idazienda";
    if (!$conn->query($query)){ $error = true; }
    else
    {
        $query = "DELETE FROM `utente` WHERE `id_utente` = $idazienda";
        if (!$conn->query($query)){ $error = true; }
    }
        
    if ($error)
        echo "Errore: query non riuscita o dipendenze esterne non risolte.\nControllare che tutte le entità legate a questa azienda siano state eliminate o modificate opportunamente";
    else
        echo "ok";
?>