<?php
    include "../../functions.php";
    checkLogin ( ceoType , "../../../");
    open_html ( "Assegna tutor" );    
    import("../../../");
    echo "<script src=\"scripts/script.js\"></script>";
    $conn = dbConnection ("../../../");
        
?>
<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
        
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Assegnazione tutor</h1>
                    <div id="report"> <p id="reportmessage" class="bg-success" style="text-align: center; font-size: 20px">Operazione eseguita con successo</p> </div>
                    <div class="row">
                        <?php
                        $query = "SELECT id_studente, cognome, nome, tutor_id_tutor FROM studente WHERE azienda_id_azienda = ".$_SESSION['userId']." ORDER BY cognome";
                        $result = $conn->query($query);
                        $Query = "SELECT id_tutor, cognome, nome FROM tutor WHERE azienda_id_azienda = ".$_SESSION['userId']." ORDER BY cognome";
                        $resulttutor = $conn->query($Query);
                        $I=0;
                        echo "<div class=\"table-responsive\"><table class=\"table table-hover\"> <thead> <th style=\"width : 33.3%\"> Studente </th> "
                        . "<th style=\"width : 33.3%\"> Tutor assegnato </th> "
                        . "<th style=\"width : 33.3%; text-align : center\"> Azioni </th> </thead> <tbody>";
                        while ($row = $result->fetch_assoc())
                        {
                            $cognome = $row['cognome'];
                            $nome = $row['nome'];
                            $idtutorassegnato = $row['tutor_id_tutor'];
                            echo "<tr id=\"riga$I\">"
                            . "<td>"
                                        . "<h3 id=\"studente$I\" name=\"".$row["id_studente"]."\">" . $cognome . " " . $nome . "</h3>"
                            . "</td>";                            
                            
                            echo "<td><div id=\"actionsbox$I\">"
                            . "<select id=\"tutor$I\" class=\"form-control\" onchange=\"javascript:changeTutor($('#studente".$I."').attr('name'), $(this).find(':selected').val())\"> ";
                            if (!isset($idtutorassegnato)) echo "<option value=\"-1\"> </option>"; 
                            while ($rowtutor = $resulttutor->fetch_assoc())
                            {
                                $selected = ($idtutorassegnato === $rowtutor['id_tutor']) ? "selected = \"selected\"" : "";
                                echo "<option $selected value=\"".$rowtutor['id_tutor']."\"> ".$rowtutor['cognome']." ".$rowtutor['nome']." </option>";
                            }                            
                            echo "</select></td>";
                            echo "<td>";
                            echo "<div align=\"center\"> <button id=\"disassegna$I\" class=\"btn btn-danger\" type=\"button\" onclick=\"freeStudent($('#studente".$I."').attr('name'), $I)\" > Disassegna </button> </div>";
                            $resulttutor->data_seek(0);
                            echo "</div></td></tr>";
                            $I++;
                        }
                        echo "</tbody></table></div>";                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var count = parseInt(<?php echo ($I) ?>);
        for (var I=0 ; I< count ; I++)
        {
            $("#tutor"+I).css("margin-top", parseInt($("#riga"+I).css("height")) / 8);
            $("#disassegna"+I).css("margin-top", parseInt($("#riga"+I).css("height")) / 8);
            $("#studente"+I).css("margin-top", parseInt($("#riga"+I).css("height")) / 8);
        }
    </script>
</body>
<?php
    close_html ("../../../");
?>