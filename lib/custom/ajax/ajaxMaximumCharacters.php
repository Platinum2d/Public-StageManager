<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    include "../../../pages/functions.php";
    require '../../../db_config.php';
    
    $conn = dbConnection("../../../");

    $table = $_POST['table'];
    $column = (isset($_POST['column']) && !empty($_POST['column'])) ? $_POST['column'] : null; //opzionale, se non viene passato vengono restituite le lunghezze di tutti i campi
    
    $query = "SELECT COLUMN_NAME, CHARACTER_MAXIMUM_LENGTH 
              FROM information_schema.columns
              WHERE TABLE_SCHEMA = '$dbname' AND 
              TABLE_NAME = '$table'";
    
    if (null !== $column) $query .= "AND COLUMN_NAME = '$column'";
    
    $result = $conn->query($query);
    if (is_object($result) && $result->num_rows > 0)
    {
        $xml->addChild("esito", "1");
        $colonne = $xml->addChild("colonne");
        while ($row = $result->fetch_assoc())
        {
            $colonna = $colonne->addChild("colonna");
            $colonna->addChild("nome", $row['COLUMN_NAME']);
            $colonna->addChild("lunghezza_massima", $row['CHARACTER_MAXIMUM_LENGTH']);
        }        
    }
    else
        $xml->addChild("esito", "0");
    
    echo $xml->asXML();
    