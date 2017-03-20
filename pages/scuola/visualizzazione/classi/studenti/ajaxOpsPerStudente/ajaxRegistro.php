<?php
    
    include "../../../../../functions.php";
        
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    
    $xml = new SimpleXMLElement ( $xmlstr );
            
    $conn = dbConnection("../../../../../../");
    $idstud = $_POST['studente'];
        
    $query = "SELECT * FROM `lavoro_giornaliero` WHERE `studente_id_studente`=$idstud ORDER BY `data` ASC";
    $result = $conn->query($query);
     
    $registro = $xml->addChild("registro");
    
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $lavorogiornaliero = $registro->addChild("lavorogiornaliero");
            $lavorogiornaliero->addChild('data',$row['data']);
            $lavorogiornaliero->addChild('descrizione',$row['descrizione']);
        }
    }
    
    echo $xml->asXML();
?>