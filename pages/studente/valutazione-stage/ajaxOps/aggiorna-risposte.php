<?php
include "../../../functions.php";
if (isset($_SESSION ['studenteHasStageId'])) {
    $shs = $_SESSION ['studenteHasStageId'];
    $conn = dbConnection("../../../../");
    
    $no_empty = true;
    $risposte = json_decode(stripslashes(($_POST['data'])));
    
    foreach ($risposte as $risposta) {
        $risposta->risposta = trim ($conn->escape_string($risposta->risposta));
        if (empty ($risposta->risposta)) {
            $no_empty = false;
            break;
        }
        if (!intval($risposta->libera)) {
            $valore = $risposta->risposta;
            $query_risposta = "SELECT opzione
                                FROM possibile_risposta_colonna_stage
                                WHERE id_possibile_risposta_colonna_stage = $valore;";
            $result = $conn->query ( $query_risposta );
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc ();
                $risposta->risposta = $row ['opzione'];
            }
            else {
                $no_empty = false;
                break;
            }
        }
    }
    
    if ($no_empty) {
        foreach ($risposte as $risposta) {
            $id_col = intval($conn->escape_string($risposta->id_col));
            $id_rig = intval($conn->escape_string($risposta->id_rig));
            $valore = $risposta->risposta;
            
            $query = "UPDATE risposta_voce_modulo_stage
                        SET risposta = '$valore'
                        WHERE riga_modulo_stage_id_riga_modulo_stage = $id_rig
                        AND colonna_modulo_stage_id_colonna_modulo_stage = $id_col
                        AND studente_has_stage_id_studente_has_stage = $shs;";
            
            if (!$conn->query ($query))
            {
                echo "Errore nella query";
            }
        }
        echo "ok";
    }
    else {
        echo "qualche risposta vuota";
    }
}
else {
    echo "Nessun'assegnazione ad uno stage";
}
?>