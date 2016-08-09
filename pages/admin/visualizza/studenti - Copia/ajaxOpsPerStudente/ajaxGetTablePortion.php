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
    $classe = $_POST['classe'];
    
    $query = "SELECT * FROM studente WHERE classe_id_classe = $classe ORDER BY cognome LIMIT $tupledastampare OFFSET $offset";
    
    if ($result = $connessione->query($query))
    {
//        $studenti = $xml->addChild("studenti");
        $I = 0;
        $html = "";
        while ($row = $result->fetch_assoc())
        {
//            $studente = $studenti->addChild("studente");
//            $studente->addChild("id",$row['id_studente']);
//            $studente->addChild("username",$row['username']);
//            $studente->addChild("nome",$row['nome']);
//            $studente->addChild("cognome",$row['cognome']);
            
            $html .= "<tr><td class=\"minw\"><div id=\"VisibleBox".$I."\"><label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\"></div>"
                    . "</td><td><div id=\"ButtonBox".$I."\" align=\"center\"> <input class = \"btn btn-success \" name=\"".$row['id_studente']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"> <input class=\"btn btn-info\" type=\"button\" value=\"Registro\" onclick=\"openRegistro('registro$I',".$row['id_studente'].")\" id=\"registro".$I."\"> <input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData(".$row['classe_id_classe'].",$('#modifica".$I."').closest('input').attr('name'))\"> "
                    . "</div></td></tr>";
            $I++;            
        }
    }
    
    echo $html;