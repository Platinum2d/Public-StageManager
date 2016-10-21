<?php
    include "../../../functions.php";
    
    $conn = dbConnection("../../../../");
    
    $data = $_POST['data'];
    $descrizione = $conn->escape_string($_POST['descrizione']);
    $idstudente = $_SESSION['userId'];
                                    
    $queryStage = "SELECT classe_has_stage.stage_id_stage
					FROM studente, studente_attends_classe, anno_scolastico, classe_has_stage, classe 
					WHERE studente.id_studente =  $idstudente
					AND anno_scolastico.corrente = 1 
					AND studente.scuola_id_scuola = classe.scuola_id_scuola 
					AND studente_attends_classe.studente_id_studente = studente.id_studente 
					AND studente_attends_classe.classe_id_classe  = classe.id_classe 
					AND studente_attends_classe.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico 
					AND classe_has_stage.classe_id_classe = classe.id_classe 
					AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico;";
    $result = $conn->query($queryStage);
    $row = $result->fetch_assoc ();
    $idStage = $row ['stage_id_stage'];
    
    $query = "INSERT INTO `lavoro_giornaliero` (data,descrizione,studente_id_studente,stage_id_stage) VALUES ('$data','$descrizione',$idstudente,$idStage)";
    
    if($conn->query($query))
    {
        $query = "SELECT MAX(id_lavoro_giornaliero) FROM lavoro_giornaliero";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        echo $row['MAX(id_lavoro_giornaliero)'];
    }
    