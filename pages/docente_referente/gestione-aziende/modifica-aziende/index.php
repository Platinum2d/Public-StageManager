<?php
    include '../../../functions.php';
    checkLogin ( docrefType , "../../../../");
    open_html ( "Visualizza Aziende" );
    import("../../../../");
    $conn = dbConnection("../../../../");
?>
<style>
    .minw{
        width: 65%;
    }
    
    .custlabel{
        margin-bottom: 0px;
        margin-top: 5px;
    }
</style>
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <script src="scripts/scripts.js?0.1"></script>
    
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Modifica Aziende</h1> <br>
<!--                    <div class="row">
                        <div class="col col-sm-4">
                            <div align="left">
                                <p style="display: inline">Cerca</p> <input style="display: inline" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col col-sm-4">
                            Azione<div align="center">
                                <select class="form-control" id="actions">
                                    <option>  </option>                                    
                                    <option value="1"> Espandi </option>
                                    <option value="2"> Riduci </option>
                                    <option value="3"> Elimina </option>
                                </select>
                            </div>
                        </div>
                            
                        <div class="col col-sm-4"> 
                            Filtra righe<div align="right">
                                <form style="display: inline" action="" method="POST" id="manualcustomredirect">
                                    <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php echo $recordperpagina ?>">
                                </form>
                            </div>
                        </div>
                    </div>    -->


                    <?php
                      
                        $query = "SELECT * FROM azienda, utente WHERE tipo_utente = 4 AND id_utente = id_azienda ORDER BY azienda.nome_aziendale";
                        $result = $conn->query($query);
                        echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                        $I=0;
                        echo "<br><div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tableaziende\"> <thead style=\"background : #eee; font-color : white \"> <!--<th><div align=\"center\"><input type=\"checkbox\" id=\"checkall\"></div></th> --><th style=\"text-align : center\"> Nome azienda, Username  </th> <th style=\"text-align : center\"> Azioni </th></thead> <tbody>";
                        if($result->num_rows > 0)
                        {
                            while ($row = $result->fetch_assoc())
                            {
                                echo "<tr id=\"riga$I\"><!--<td style=\"width: 5px\"><div align=\"center\"><input id=\"check$I\" type=\"checkbox\" class=\"singlecheck\"></div></td>--><td class=\"minw\">";
                                echo "<div id=\"VisibleBox$I\">";
                                    echo "<label id=\"label".$I."\" name=\"".$row['id_azienda']."\"> ".$row['nome_aziendale']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<div align=\"center\" id=\"ButtonBox$I\">"
                                            . "<button class=\"btn btn-success\" id=\"modifica$I\" value=\"\" onclick=\"openEdit('$I','".$row['id_azienda']."')\"><span class='glyphicon glyphicon-edit'></span>  Modifica</button>"
                                            . "    <button class=\"btn btn-danger\" value=\"\" onclick = \"deleteAzienda(".$row['id_azienda'].")\"><span class='glyphicon glyphicon-remove'></span>  Elimina</button></div>";
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