<?php
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    
    $nomemodulo = $conn->escape_string(trim(strip_tags($_POST['nome'])));
    $descrizionemodulo = $conn->escape_string(trim(strip_tags($_POST['descrizione'])));
    $tipo = $conn->escape_string($_POST['tipo']);
    $id_docente = $_SESSION['userId'];
    
    $query_scuola = "SELECT scuola_id_scuola
                        FROM docente
                        WHERE docente.id_docente = $id_docente;";
    if ($result = $conn->query($query_scuola)) {
        if ( $row = $result->fetch_assoc()) {
            $scuola = $row ['scuola_id_scuola'];
            $tabella = null;
            
            if ($tipo === "studente") {
                $tabella = "modulo_valutazione_studente";
            }
            elseif($tipo === "azienda") {
                $tabella = "modulo_valutazione_stage";
            }
                
            $query = "INSERT INTO $tabella (nome, descrizione, scuola_id_scuola) VALUES ('$nomemodulo', '$descrizionemodulo', $scuola)";
            if ($conn->query($query)) {
                    echo "ok";
            }
            else {
                echo $conn->error;
            }
        }
        else {
            echo "Problema";
        }
    }
    else {
        echo $conn->error;
    }
?>