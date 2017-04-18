<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Visualizza Aziende" );
    import("../../../../");
    $conn = dbConnection("../../../../");
?>
<body>
    <style>
        .minw{
            width: 65%;
        }
            
        .custlabel{
            margin-bottom: 0px;
            margin-top: 5px;
        }
    </style>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <script src="scripts/scripts.js?1"></script>
        
    <input type="hidden" id="secureDelete" value="0">
        
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Modifica Aziende</h1> <br>
                    <?php                                          
                        $query = "SELECT * FROM azienda, utente WHERE tipo_utente = ".ceoType." AND id_utente = id_azienda ORDER BY username";
                        $result = $conn->query($query);
                        echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                        $I=0;
                        echo "<br><div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tableaziende\"> <thead style=\"background : #eee; font-color : white \"> <th><div align=\"center\"><input type=\"checkbox\" id=\"checkall\"></div></th> <th style=\"text-align : center\"> Nome azienda, Username  </th> <th style=\"text-align : center\"> Azioni </th></thead> <tbody>";
                        if($result->num_rows > 0)
                        {
                            while ($row = $result->fetch_assoc())
                            {
                                echo "<tr id=\"riga$I\"><td style=\"width: 5px\"><div align=\"center\"><input id=\"check$I\" type=\"checkbox\" class=\"singlecheck\"></div></td><td class=\"minw\">";
                                echo "<div id=\"VisibleBox$I\">";
                                    echo "<label id=\"label".$I."\" name=\"".$row['id_azienda']."\"> ".$row['nome_aziendale']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<div align=\"center\" id=\"ButtonBox$I\">"
                                            . "<button class=\"btn btn-success\" id=\"modifica$I\" value=\"\" onclick=\"openEdit('$I','".$row['id_azienda']."')\"><span class='glyphicon glyphicon-edit'></span>  Modifica</button>"
                                            . "    <button class=\"btn btn-danger\" value=\"\" onclick = \"askForDeleteAzienda(".$row['id_azienda'].", $I)\"><span class='glyphicon glyphicon-trash'></span>  Elimina</button></div>";
                                echo "</td>";                                                    
                                echo "</tr>";
                                $I++;
                            }
                        }
                        echo "</tbody></table></div>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>