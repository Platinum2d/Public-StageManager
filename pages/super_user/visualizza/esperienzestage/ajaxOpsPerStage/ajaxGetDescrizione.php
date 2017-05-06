<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );    
    include '../../../../functions.php';
    $conn = dbConnection("../../../../../");
    
    $id = $_POST['id'];
    $tb = $_POST['tb'];
    
    $query = "SELECT descrizione "
            . "FROM modulo_valutazione_$tb "
            . "WHERE id_modulo_valutazione_".$tb." = $id";
    
    $result = $conn->query($query);
    
    if (is_object($result) && $result->num_rows > 0)
    {
        echo $result->fetch_assoc()['descrizione'];
    }