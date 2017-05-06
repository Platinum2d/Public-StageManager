<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );    
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    
    $scuola = $_SESSION['userId'];
    $exception = (isset($_POST['exception']) && !empty($_POST['exception'])) ? $_POST['exception'] : null;
    
    $query = "SELECT * FROM modulo_valutazione_stage WHERE scuola_id_scuola = $scuola";
    if (null !== $exception) $query .= " AND id_modulo_valutazione_stage != $exception";
    
    $query .= " ORDER BY nome";
    
    $result = $conn->query($query);
    
    if (is_object($result) && $result->num_rows > 0)
    {
        $moduli = $xml->addChild("moduli");
        while ($row = $result->fetch_assoc())
        {
            $modulo = $moduli->addChild("modulo");
            $modulo->addChild("id", $row['id_modulo_valutazione_stage']);
            $modulo->addChild("nome", $row['nome']);
            $modulo->addChild("descrizione", $row['descrizione']);
        }
    }
    
    echo $xml->asXML();
        
        