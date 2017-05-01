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
    $idscuola = $_SESSION['userId'];
    
    $xml = new SimpleXMLElement ( $xmlstr );
    
    $query = "  SELECT id_classe, nome 
                FROM classe 
                WHERE classe.scuola_id_scuola = $idscuola 
                AND id_classe NOT IN(   SELECT classe.id_classe 
                                        FROM classe, docente_referente_has_classe_has_stage AS drhchs, classe_has_stage AS chs 
                                        WHERE drhchs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                                        AND chs.classe_id_classe = classe.id_classe 
                                        AND chs.anno_scolastico_id_anno_scolastico = $idanno 
                                        AND drhchs.docente_id_docente = $id_doc);";
    
    $result = $conn->query($query);
    if (is_object($result) && $result->num_rows > 0)
    {
        $classivalide = $xml->addChild("classi_valide");
        while ($row = $result->fetch_assoc())
        {
            $idclasse = $row['id_classe'];
            $nomeclasse = $row['nome'];
            $countquery = " SELECT COUNT(*) AS count
                            FROM classe_has_stage 
                            WHERE classe_has_stage.classe_id_classe = $idclasse 
                            AND classe_has_stage.anno_scolastico_id_anno_scolastico = $idanno;";
            
            $countesperienze = intval($conn->query($countquery)->fetch_assoc()['count']);
            
            if ($countesperienze > 0)
            {
                $classevalida = $classivalide->addChild("classe_valida");
                $classevalida->addChild("id", $idclasse);
                $classevalida->addChild("nome", $nomeclasse);
            }
        }
    }
    
    echo $xml->asXML();