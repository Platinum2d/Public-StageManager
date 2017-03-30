<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    include "../../../../functions.php";
    $conn = dbConnection("../../../../../");
    
    $id_doc = $_POST['docente'];
    $idanno = $_POST['anno'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $classesquery = "SELECT id_classe, nome FROM classe WHERE scuola_id_scuola = ".$_SESSION['userId'];

    $resultclasses = $conn->query($classesquery);
    while ($row = $resultclasses->fetch_assoc())
    {
        $classivalide = $xml->addChild("classi_valide");
        
        $current_classe_id = $row['id_classe'];
        $current_classe_nome = $row['nome'];
        
        $num_stud_current_class_query = "SELECT COUNT(sac.id_studente_attends_classe) AS count "
                                                     . "FROM studente_attends_classe AS sac "
                                                     . "WHERE sac.classe_id_classe = $current_classe_id "
                                                     . "AND sac.anno_scolastico_id_anno_scolastico = $idanno";                                
        $num_stud_current_class = intval($conn->query($num_stud_current_class_query)->fetch_assoc()['count']);
        
        $num_stud_gestiti_current_doc_query = "SELECT COUNT(drhshs.id_docente_has_studente_has_stage) AS count 
                                                             FROM studente_has_stage AS shs, classe_has_stage AS chs, docente_referente_has_studente_has_stage AS drhshs 
                                                             WHERE drhshs.studente_has_stage_id_studente_has_stage = shs.id_studente_has_stage 
                                                             AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                                                             AND chs.classe_id_classe = $current_classe_id 
                                                             AND chs.anno_scolastico_id_anno_scolastico = $idanno 
                                                             AND drhshs.docente_id_docente = $id_doc;";
        
        $num_stud_gestiti_current_doc = intval($conn->query($num_stud_gestiti_current_doc_query)->fetch_assoc()['count']);
        
        $classe_has_stage_query = "SELECT COUNT(id_classe_has_stage) AS count FROM classe_has_stage WHERE classe_id_classe = $current_classe_id AND anno_scolastico_id_anno_scolastico = $idanno";
        $num_esperienze_classe_corrente = intval($conn->query($classe_has_stage_query)->fetch_assoc()['count']);
        
        if ($num_esperienze_classe_corrente > 0 && $num_stud_current_class > 0 && $num_stud_gestiti_current_doc === 0)
        {
            $classevalida = $classivalide->addChild("classe_valida");
            $classevalida->addChild("id", $current_classe_id);
            $classevalida->addChild("nome", $current_classe_nome);
        }
    }
    
    echo $xml->asXML();