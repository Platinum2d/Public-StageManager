<?php
    $xmlstr = '<?xml version="1.0" encoding="utf-8" ?>   <data> </data>';

    include '../../../../../functions.php';
    $xml = new SimpleXMLElement ( $xmlstr ); 
        
    $connessione = dbConnection("../../../../../../");
    $exception = $_POST['exception'];
    $idanno = $_POST['id_anno'];
    $idscuola = $connessione->query("SELECT s.id_scuola FROM scuola AS s, classe AS c WHERE s.id_scuola = c.scuola_id_scuola AND c.id_classe = $exception")->fetch_assoc()["id_scuola"];
    
    $query = "SELECT c.nome, c.id_classe FROM classe AS c WHERE c.id_classe <> $exception AND c.scuola_id_scuola = $idscuola ";
    
    $result = $connessione->query($query);
    $classi = $xml->addChild("classi");
    while ($row = $result->fetch_assoc())
    {
        $classe = $classi->addChild("classe");
        $classe->addChild("id", $row['id_classe']);
        $classe->addChild("nome", $row['nome']);
    }
    echo $xml->asXML();