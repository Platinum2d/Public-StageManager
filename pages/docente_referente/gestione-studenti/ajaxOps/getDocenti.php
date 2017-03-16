<?php
    include '../../../functions.php';
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
        $connessione = dbConnection("../../../../");
    
        $id_classe = $_POST['id'];
        
        $query =  "SELECT docente.id_docente, docente.nome, docente.cognome, docente.telefono, docente.email
                    FROM docente, anno_scolastico, classe_has_docente
                    WHERE classe_has_docente.classe_id_classe = $id_classe
                    AND classe_has_docente.docente_id_docente = docente.id_docente
                    AND classe_has_docente.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                    AND anno_scolastico.corrente = 1
                    ORDER BY docente.cognome;";
        
        if ($result = $connessione->query($query)) {
            $xml->addChild("status", "1");
            while ($row = $result->fetch_assoc())
            {
                $docente = $xml->addChild("docente");
                $docente->addChild("id", $row['id_docente']);
                $docente->addChild("nome", $row['nome']);
                $docente->addChild("cognome", $row['cognome']);
            }        
        }
        else {
            $xml->addChild("status", "0");
        }    
        echo $xml->asXML();
?>