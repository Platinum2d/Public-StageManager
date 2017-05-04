<?php
            $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    include '../../../../../../functions.php';
    $conn = dbConnection("../../../../../../../");
    
    $xml = new SimpleXMLElement ( $xmlstr );
    $colonna = $_POST['colonna'];
    
    $query = "SELECT id_possibile_risposta_colonna_studente, opzione, numero_voce "
            . "FROM possibile_risposta_colonna_studente "
            . "WHERE colonna_modulo_studente_id_colonna_modulo_studente = $colonna";
    
    $result = $conn->query($query);
    
    if (is_object($result) && $result->num_rows > 0)
    {
        $opzioni = $xml->addChild("opzioni");
        while ($row = $result->fetch_assoc())
        {
            $id = $row['id_possibile_risposta_colonna_studente'];
            $descrizione = $row['opzione'];
            $posizione = $row['numero_voce'];
            
            $opzione = $opzioni->addChild("opzione");
            $opzione->addChild("id", $id);
            $opzione->addChild("descrizione", $descrizione);
            $opzione->addChild("posizione", $posizione);
        }
        echo $xml->asXML();
    }