<?php

    include "../../../../../functions.php";
    $conn = dbConnection("../../../../../../");
    
    $id = $_POST['id'];
    
    $errore = false;
    
    $colonne_fetch_query = "SELECT * FROM colonna_modulo_stage WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $id";
    $result_colonne = $conn->query($colonne_fetch_query);
    
    if (is_object($result_colonne) && $result_colonne->num_rows > 0)
    {
        while ($row_colonna = $result_colonne->fetch_assoc())
        {
            $id_colonna = $row_colonna['id_colonna_modulo_stage'];
            $multipla = intval($row_colonna['risposta_multipla']);
            
            if ($multipla === 1)
            {
                $opzioni_query = "DELETE FROM possibile_risposta_colonna_stage WHERE colonna_modulo_stage_id_colonna_modulo_stage = $id_colonna";
                if (!$conn->query($opzioni_query)) $errore = true;
            }
            
            $risposte_query = "DELETE FROM risposta_voce_modulo_stage WHERE colonna_modulo_stage_id_colonna_modulo_stage = $id_colonna";
            if (!$conn->query($risposte_query)) $errore = true;
        }
        
        $righe_query = "DELETE FROM riga_modulo_stage WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $id";
        $colonne_query = "DELETE FROM colonna_modulo_stage WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $id";
        
        if (!$conn->query($righe_query) || !$conn->query($colonne_query)) $errore = true;
        
        $chs_query = "UPDATE classe_has_stage SET modulo_valutazione_stage_id_modulo_valutazione_stage = NULL WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $id";
        if (!$conn->query($chs_query)) $errore = true;
    }
    
    $modulo_query = "DELETE FROM modulo_valutazione_stage WHERE id_modulo_valutazione_stage = $id";
    if (!$conn->query($modulo_query)) $errore = true;
    
    if (!$errore)
        echo "ok";
    else 
        echo $conn->error;