<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );    
    include '../../../../../functions.php';
    $conn = dbConnection("../../../../../../");
    
    $chs = $_POST['chs'];
    
    $query = "  SELECT id_modulo_valutazione_stage, nome, descrizione 
                FROM modulo_valutazione_stage AS mvs, classe_has_stage AS chs 
                WHERE chs.modulo_valutazione_stage_id_modulo_valutazione_stage = mvs.id_modulo_valutazione_stage  
                AND chs.id_classe_has_stage = $chs";
    
    $result = $conn->query($query);
    if (is_object($result) && $result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        
        $modulo = $xml->addChild("modulo_valutazione_stage");
        $modulo->addChild("id", $row['id_modulo_valutazione_stage']);
        $modulo->addChild("nome", $row['nome']);
        $modulo->addChild("descrizione", $row['descrizione']);
    }
    
    $query = "  SELECT id_modulo_valutazione_studente, nome, descrizione 
                FROM modulo_valutazione_studente AS mvs, classe_has_stage AS chs 
                WHERE chs.modulo_valutazione_studente_id_modulo_valutazione_studente = mvs.id_modulo_valutazione_studente 
                AND chs.id_classe_has_stage = $chs";

    $result = $conn->query($query);
    if (is_object($result) && $result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        
        $modulo = $xml->addChild("modulo_valutazione_studente");
        $modulo->addChild("id", $row['id_modulo_valutazione_studente']);
        $modulo->addChild("nome", $row['nome']);
        $modulo->addChild("descrizione", $row['descrizione']);
    }

    echo $xml->asXML();