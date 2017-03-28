<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_doc = $_POST['docente'];
    $id_classe = $_POST['classe'];
    $id_anno = $_POST['anno'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "SELECT id_docente_has_studente_has_stage, id_studente, stud.nome, stud.cognome 
              FROM studente AS stud, classe_has_stage AS chs, studente_has_stage AS shs, docente_referente_has_studente_has_stage AS drhshs 
              WHERE shs.studente_id_studente = stud.id_studente 
              AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
              AND drhshs.studente_has_stage_id_studente_has_stage = shs.id_studente_has_stage 
              AND chs.classe_id_classe = $id_classe 
              AND chs.anno_scolastico_id_anno_scolastico = $id_anno 
              AND drhshs.docente_id_docente = $id_doc 
              ORDER BY cognome, nome ASC";
    
    $result = $conn->query($query);
    if (is_object($result) && $result->num_rows > 0)
    {
        $studenti = $xml->addChild("studenti");
        while ($row = $result->fetch_assoc())
        {
            $studente = $studenti->addChild("studente");
            $studente->addChild("id", $row['id_studente']);
            $studente->addChild("id_drhshs", $row['id_docente_has_studente_has_stage']);
            $studente->addChild("nome", $row['nome']);
            $studente->addChild("cognome", $row['cognome']);
        }
    }
    
    echo $xml->asXML();