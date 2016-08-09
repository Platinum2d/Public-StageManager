<?php
    include '../../functions.php';
    $conn = dbConnection ();
    
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
    $id_studente = $_POST ['id_studente'];
    
    // /vedere se il campo valutazione nella tabella studente è null o no e dal risultato ottenuto fare insert o update
    
    $sql = "select `valutazione_studente_id_valutazione_studente` from studente where `valutazione_studente_id_valutazione_studente` IS NULL AND `id_studente`=  $id_studente OR `valutazione_studente_id_valutazione_studente` IS NOT NULL AND `id_studente`=  $id_studente";
    
    $Result = $conn->query ( $sql );
    if ($Result) {
        $row = $Result->fetch_assoc ();
        if ($row ['valutazione_studente_id_valutazione_studente'] != NULL) {
            $valquery = $row ['valutazione_studente_id_valutazione_studente'];
            $execute = "UPDATE `valutazione_studente` SET `gestione_ambiente_spazio_lavoro`=$gasl,`collaborazione_comunicazione`=$cc,`uso_strumenti`=$us,`rispetta_norme_vigenti`=$cca,`rispetto_ambiente`=$vgs,`puntualita`=$cl,`collaborazione_tutor`= $ccap,`lavoro_requisiti`=$ee,`conoscenze_tecniche`=$qp,`acquisire_nuove_conoscenze`=$ef where `id_valutazione_studente`= $valquery;";
        } else {
            $execute = "INSERT INTO `valutazione_studente`(`gestione_ambiente_spazio_lavoro`, `collaborazione_comunicazione`, `uso_strumenti`, `rispetta_norme_vigenti`, `rispetto_ambiente`, `puntualita`, `collaborazione_tutor`, `lavoro_requisiti`, `conoscenze_tecniche`, `acquisire_nuove_conoscenze`) VALUES ($gasl, $cc,$us,$cca, $vgs,$cl, $ccap,$ee,$qp,$ef)";
        }
        if ($conn->query ( $execute )) echo "ok";
        else echo $conn->error;
//        $sql = "SELECT `id_valutazione_studente` FROM valutazione_studente ORDER BY `id_valutazione_studente` DESC LIMIT 1";
//        $Result = $conn->query ( $sql );
//        $row = $Result->fetch_assoc ();
//        $valquery2 = $row ['id_valutazione_studente'];
////        $sql = "UPDATE `studente` SET valutazione_studente_id_valutazione_studente= $valquery2 where id_studente= $id_studente";
////        $conn->query ( $sql );
        
    }
?>