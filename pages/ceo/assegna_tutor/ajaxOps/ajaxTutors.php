<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );

    include "../../../functions.php";
    $conn = dbConnection ("../../../../");
    
    $exclusion = (intval($_POST['exclusion']) !== -1 && isset($_POST['exclusion']) && !empty($_POST['exclusion'])) ? $_POST['exclusion'] : null;
    
    $query = "SELECT * FROM utente, tutor WHERE id_tutor = id_utente AND azienda_id_azienda = ".$_SESSION['userId']." ";
    if (isset($exclusion) && !empty($exclusion)) $query .= "AND id_tutor != $exclusion";
    
    $query .= " ORDER BY cognome ASC";
    
    $result = $conn->query($query);
    $tutors = $xml->addChild("tutors");
    while ($row = $result->fetch_assoc())
    {
        $tutor = $tutors->addChild("tutor");
        $tutor->addChild("id", $row['id_tutor']);
        $tutor->addChild("username", $row['username']);
        $tutor->addChild("nome", $row['nome']);
        $tutor->addChild("cognome", $row['cognome']);
    }
    
    echo $xml->asXML();