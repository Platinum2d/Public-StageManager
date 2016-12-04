<?php
    include '../../../../functions.php';
    $connessione = dbConnection("../../../../../");
    $id = $_POST['id'];
    
    $Query = "DELETE FROM `studente` WHERE `id_studente` = $id";
    $connessione->query("SET FOREIGN_KEY_CHECKS = 0");
    
    if ($connessione->query($Query))
    {
        $Query = "DELETE FROM `studente_has_preferenza` WHERE `studente_id_studente` = $id";
        $connessione->query($Query);
        
        $Querytot = ''; $Querytot = $Querytot . $Query;
        
        $Query = "SELECT valutazione_stage_id_valutazione_stage FROM studente WHERE valutazione_stage_id_valutazione_stage IS NOT NULL AND id_studente = $id";
        $result = $connessione->query($Query);
        $Querytot = $Querytot . $Query;
        if ($result->num_rows !== 0)
        {
            $row = $result->fetch_assoc();
            $Query = "DELETE FROM `valutazione_stage` WHERE `id_valutazione_stage` = ".$row['valutazione_stage_id_valutazione_stage'];
            $connessione->query($Query);
            $Querytot = $Querytot . $Query;
            echo $Querytot;
        }
        echo $Querytot;
    }
    else echo $connessione->error;
    
    $connessione->query("SET FOREIGN_KEY_CHECKS = 1");
?>