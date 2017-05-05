<?php
    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $idcolonna = $_POST['colonna'];
    $errore = false;
    
    $possibilita_query = "DELETE FROM possibile_risposta_colonna_studente WHERE colonna_modulo_studente_id_colonna_modulo_studente = $idcolonna";
    if (!$conn->query($possibilita_query)) $errore = true;
    
    $risposte_query = "DELETE FROM risposta_voce_modulo_studente WHERE colonna_modulo_studente_id_colonna_modulo_studente = $idcolonna";
    if (!$conn->query($risposte_query)) $errore = true;
    
    $query = "DELETE FROM colonna_modulo_studente WHERE id_colonna_modulo_studente = $idcolonna";
    if (!$conn->query($query)) $errore = true;
    
    if (!$errore)
        echo "ok";
    else
        echo $conn->error;