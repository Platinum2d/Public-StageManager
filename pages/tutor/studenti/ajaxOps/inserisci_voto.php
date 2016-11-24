<?php    

    include "../../../functions.php";

    $gasl = $_POST ['gestione_ambiente_spazio_lavoro'];
    $cc = $_POST ['collaborazione_comunicazione'];
    $us = $_POST ['uso_strumenti'];
    $cca = $_POST ['complessita_compito_atteggiamento'];
    $vgs = $_POST ['valutazione_gestione_sicurezza'];
    $cl = $_POST ['competenze_linguistiche'];
    $ccap = $_POST ['conoscenza_coerenza_approfondimento'];
    $ee = $_POST ['efficacia_esposizone'];
    $qp = $_POST ['qualita_processo'];
    $ef = $_POST ['efficacia_prodotto'];
    $id_studente_has_stage = $_POST ['id_studente_has_stage'];
    
    $conn = dbConnection("../../../../");
    $query = "INSERT INTO `valutazione_studente` (`gestione_ambiente_spazio_lavoro`, `collaborazione_comunicazione`, `uso_strumenti`, `rispetta_norme_vigenti`, `rispetto_ambiente`, `puntualita` ,`collaborazione_tutor`, `lavoro_requisiti`, `conoscenze_tecniche`, `acquisire_nuove_conoscenze`,  `commento`) "
            . "VALUES ('$gasl', '$cc', '$us', '$cca', '$vgs', '$cl', '$ccap', '$ee', '$qp', '$ef', NULL);";
    if ($conn->query($query))
    {
    	$id_valutazione = $conn->insert_id;
        $query = "UPDATE  `studente_has_stage` SET  `valutazione_studente_id_valutazione_studente` =  $id_valutazione WHERE id_studente_has_stage = $id_studente_has_stage";
        $conn->query($query);
        echo "ok";  
    }
    else
        echo $conn->error;