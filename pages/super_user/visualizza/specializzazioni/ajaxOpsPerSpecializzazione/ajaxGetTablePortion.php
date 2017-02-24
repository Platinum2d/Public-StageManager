<?php

    include '../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
$connessione = dbConnection("../../../../../");

    $offset = $_POST['offset'];
    $tupledastampare = $_POST['tuple'];
    
    $query = "SELECT * FROM specializzazione ORDER BY nome LIMIT $tupledastampare OFFSET $offset";
    
    if ($result = $connessione->query($query))
    {
//        $studenti = $xml->addChild("studenti");
        $I = 0;
        $html = "";
        while ($row = $result->fetch_assoc())
        {
            $html .= "<tr><td class=\"minw\"><div id=\"VisibleBox".$I."\"><label id=\"label".$I."\"> ".$row['nome']."     </label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">"
                    . "</div></td><td><div align=\"center\" id=\"ButtonBox$I\"> <input class = \"btn btn-success\" name=\"".$row['id_specializzazione']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"> <input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData($('#modifica".$I."').closest('input').attr('name'))\"> </div>"
                    . "</td>";
            $I++;            
        }
    }
    
    echo $html;
?>