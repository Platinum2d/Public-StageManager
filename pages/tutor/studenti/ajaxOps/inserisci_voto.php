<?php    

    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");

    $gasl = $conn->escape_string ($_POST ['gestione_ambiente_spazio_lavoro']);
    $cc = $conn->escape_string ($_POST ['collaborazione_comunicazione']);
    $us = $conn->escape_string ($_POST ['uso_strumenti']);
    $cca = $conn->escape_string ($_POST ['complessita_compito_atteggiamento']);
    $vgs = $conn->escape_string ($_POST ['valutazione_gestione_sicurezza']);
    $cl = $conn->escape_string ($_POST ['competenze_linguistiche']);
    $ccap = $conn->escape_string ($_POST ['conoscenza_coerenza_approfondimento']);
    $ee = $conn->escape_string ($_POST ['efficacia_esposizone']);
    $qp = $conn->escape_string ($_POST ['qualita_processo']);
    $ef = $conn->escape_string ($_POST ['efficacia_prodotto']);
    $comm = $conn->escape_string ($_POST ['commento']);
    $id_studente_has_stage = intval ($_POST ['id_studente_has_stage']);
    
    $query = "INSERT INTO `valutazione_studente` (`gestione_ambiente_spazio_lavoro`, `collaborazione_comunicazione`, `uso_strumenti`, `rispetta_norme_vigenti`, `rispetto_ambiente`, `puntualita` ,`collaborazione_tutor`, `lavoro_requisiti`, `conoscenze_tecniche`, `acquisire_nuove_conoscenze`,  `commento`) 
                VALUES ('$gasl', '$cc', '$us', '$cca', '$vgs', '$cl', '$ccap', '$ee', '$qp', '$ef', '$comm');";
    if ($conn->query($query))
    {
    	$id_valutazione = $conn->insert_id;
        $query = "UPDATE  `studente_has_stage` SET  `valutazione_studente_id_valutazione_studente` =  $id_valutazione WHERE id_studente_has_stage = $id_studente_has_stage";
        $conn->query($query);
        echo "ok";  
    }
    else
        echo $conn->error;