<?php
    include '../../../../functions.php';
    
    $connessione = dbConnection("../../../../../");

    $id_shs = intval ($_POST['shs']);
    $id_docente = intval ($_POST['id']);
    
    $query = "UPDATE studente_has_stage
                SET docente_tutor_id_docente_tutor = $id_docente
                WHERE id_studente_has_stage = $id_shs";
    
    if ($connessione->query($query)) {
        echo "ok";
    }        
    else { 
        echo $connessione->error;
    }
?>