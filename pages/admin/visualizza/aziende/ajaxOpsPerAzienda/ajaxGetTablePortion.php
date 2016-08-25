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
    
    $query = "SELECT * FROM azienda ORDER BY username LIMIT $tupledastampare OFFSET $offset";
    
    if ($result = $connessione->query($query))
    {
//        $studenti = $xml->addChild("studenti");
        $I = 0;
        $html = "";
        while ($row = $result->fetch_assoc())
        {
            $html .= "<tr><td class=\"minw\"><div id=\"VisibleBox$I\"><label id=\"label".$I."\"> ".$row['nome_aziendale']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">"
                    . "</div></td><td><div align=\"center\" id=\"ButtonBox$I\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_azienda']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteAzienda(".$row['id_azienda'].")\"></div>"
                    . "</td></tr>";
            $I++;            
        }
    }
    
    echo $html;