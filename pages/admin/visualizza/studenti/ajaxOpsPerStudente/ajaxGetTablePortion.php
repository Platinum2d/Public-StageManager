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
            $html .= "<tr><td class=\"minw\"><div id=\"VisibleBox".$I."\"><label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\"></div>"
                    . "</td><div id=\"ButtonBox".$I."\" align=\"center\"> "
                    . "<td align=\"center\"><input class = \"btn btn-success \" name=\"".$row['id_studente']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"></td> "
                    . "<td align=\"center\"><form target=\"_blank\" method=\"POST\" action=\"registro/index.php\"> <input type=\"hidden\" name=\"idstudente\" value=\"".$row['id_studente']."\"> <input type=\"hidden\" name=\"nome\" value=\"".$row['nome']."\">"
                                                 . "<input type=\"hidden\" name=\"cognome\" value=\"".$row['cognome']."\"> <input class=\"btn btn-info\" type=\"submit\" value=\"Registro\"  id=\"registro".$I."\"> </form> </td>"
                    . "<td align=\"center\"><input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData(".$row['classe_id_classe'].",$('#modifica".$I."').closest('input').attr('name'))\"></td> "
                    . "</div></tr>";
            $I++;            
        }
    }
    
    echo $html;
?>