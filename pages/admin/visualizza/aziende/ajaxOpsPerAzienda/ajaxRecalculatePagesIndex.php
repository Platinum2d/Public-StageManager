<?php
    include '../../../../functions.php';
    $connessione = dbConnection("../../../../../");
    $recordperpagina = $_POST['recordperpagina'];
    $html = "";
    
    $querycount = "SELECT COUNT(*) FROM azienda";
    $resultcount = $conn->query($querycount);
    $rowcount = $resultcount->fetch_assoc();
    $tuple = intval($rowcount['COUNT(*)']);
    $npagine = intval($tuple / $recordperpagina);
    if ($npagine * $recordperpagina < $tuple) $npagine += 1;
    $html .= "<div align=\"center\" id=\"pages\"><ul class=\"pagination pagination-lg\">";
    for ($I = 0;$I < $npagine;$I++)
    {
        $idtoprint = $I * $recordperpagina;
        $html .= "<li><a id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint, $idtoprint)\"> ".($I + 1)." </a></li>";
    }
    $html .= "</ul></div>";
    $html .= "</div>";
    
    echo $html;
?>