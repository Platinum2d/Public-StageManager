<?php
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    
    $nomemodulo = $conn->escape_string(trim(strip_tags($_POST['nome'])));
    $descrizionemodulo = $conn->escape_string(trim(strip_tags($_POST['descrizione'])));
    $tipo = $_POST['tipo'];
    $scuola = $_SESSION['userId'];
    
    $tabella = null;
    
    if ($tipo === "studente")
        $tabella = "modulo_valutazione_studente";
    elseif($tipo === "azienda")
    {
        $tabella = "modulo_valutazione_stage";
    }
    
    $query = "INSERT INTO $tabella (nome, descrizione, scuola_id_scuola) VALUES ('$nomemodulo', '$descrizionemodulo', $scuola)";
    if ($conn->query($query))
        echo "ok";
    else
        echo $conn->error;

