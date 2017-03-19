<?php

    include '../../../../../functions.php';
    $conn = dbConnection("../../../../../../");
    
    $idstage = $_POST['stage'];
    $idclasse = $_POST['classe'];
    $idanno = $_POST['anno'];
    
    $query = "INSERT INTO classe_has_stage (stage_id_stage, classe_id_classe, anno_scolastico_id_anno_scolastico) VALUES ($idstage, $idclasse, $idanno)";
    $result = $conn->query($query);
            
    if($result)
    {
        $id_classe_has_stage = $conn->query("SELECT MAX(id_classe_has_stage) AS id FROM classe_has_stage")->fetch_assoc()['id'];
        $query = "SELECT id_studente "
                . "FROM studente AS stud, studente_attends_classe AS sac "
                . "WHERE stud.id_studente = sac.studente_id_studente "
                . "AND sac.classe_id_classe = $idclasse "
                . "AND sac.anno_scolastico_id_anno_scolastico = $idanno";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0)
        {
            $errore = false;
            while ($row = $result->fetch_assoc())
            {
                $current_studente = $row['id_studente'];

                $query = "INSERT INTO studente_has_stage ("
                        . "visita_azienda, autorizzazione_registro, studente_id_studente, "
                        . "classe_has_stage_id_classe_has_stage, valutazione_studente_id_valutazione_studente, "
                        . "valutazione_stage_id_valutazione_stage, azienda_id_azienda, "
                        . "docente_tutor_id_docente_tutor, tutor_id_tutor) "
                        . "VALUES (0, 1, $current_studente, "
                        . "$id_classe_has_stage, NULL, "
                        . "NULL, NULL, "
                        . "NULL, NULL)";
                if (!$conn->query($query))
                    $errore = true;
            }
            if (!$errore)
                echo "ok";
            else
                echo $conn->error;
        }
        else
            echo $conn->error;
    }
    else
    {
        echo $conn->error;
    }

