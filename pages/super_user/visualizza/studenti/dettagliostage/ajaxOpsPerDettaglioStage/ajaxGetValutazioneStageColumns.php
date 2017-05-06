<?php
    $xmlstr = <<<XML
    <?xml version="1.0" encoding="utf-8" ?>
    <data>
    </data>
XML;
    include '../../../../../functions.php';

    $xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../../");
    
    $chs = $_POS['chs'];
    
    $query = "SELECT cms.descrizione "
            . "FROM classe_has_stage AS chs, modulo_valutazione_stage AS mvs, colonna_modulo_stage AS cms "
            . "WHERE mvs.id_modulo_valutazione_stage = chs.modulo_valutazione_stage_id_modulo_valutazione_stage "
            . "AND cms.modulo_valutazione_stage_id_modulo_valutazione_stage = mvs.id_modulo_valutazione_stage "
            . "AND chs.id_classe_has_stage = $chs";
    
    $result = $connessione->query($query);
    if (is_object($result) && $result->num_rows > 0)
    {
        $colonne = $xml->addChild("colonne");
        while ($row = $result->fetch_assoc())
        {
            
        }
    }