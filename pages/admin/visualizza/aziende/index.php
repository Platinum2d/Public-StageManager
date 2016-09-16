<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Aziende" );
    import("../../../../");
    $conn = dbConnection("../../../../");
    $recordperpagina = (isset($_POST['customaz'])) ? intval($_POST['customaz']) : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['naziende'])) ? 10 : $_POST['naziende'];
    }
    if ($recordperpagina <= 0) {
        $result = $conn->query("SELECT COUNT(id_azienda) AS tot FROM AZIENDA");
        $row = $result->fetch_assoc();
        $recordperpagina = intval($row['tot']);
    }
?>
<body>
    <style>
        .minw{
            width: 65%;
        }
    </style>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
        printChat("../../../../");
    ?>
    <script src="scripts/scripts.js"></script>
        
    <input type="hidden" value="<?php echo $recordperpagina ?>" id="recordperpagina">
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Visualizza Aziende</h1> <br>
                    <div class="row">
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
                                <!--                                <form style="display: inline" action="" method="POST" id="manualredirect">
                                                                    <select id="slc" name="naziende">
                                                                        <option> 5 </option>
                                                                        <option> 10 </option>
                                                                        <option> 20 </option>
                                                                        <option> 30 </option>
                                                                        <option> 40 </option>
                                                                    </select>
                                                                    righe
                                                                </form>-->
                            </div>
                        </div>
                    </div>    
                        
                        
                                        <?php
                                            //echo "<div align=\"right\"><form style=\"display : inline\" action=\"\" method=\"POST\" id=\"manualcustomredirect\"> Visualizza <input type=\"number\" min=\"1\" id=\"customnum\" name=\"customaz\"> </form> <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualredirect\"> <select name=\"naziende\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> aziende per pagina </form></div> ";
                                            if (isset($_POST['naziende']))
                                            {
                                        ?>
                                            <script>
                                                var rightindex = 1;
                                                $("#slc > option").each(function() {
                                                    if (this.text === '<?php echo intval($_POST['naziende']); ?>')
                                                    rightindex = this.index;

                                                    $("#slc").prop('selectedIndex', rightindex);
                                                });
                                            </script>      
                                      <?php }
                                            else 
                                            { ?> 
                                            <script> $("#slc").prop('selectedIndex', 1); </script> 
                                      <?php }
                                          
                                            $query = "SELECT * FROM azienda ORDER BY username LIMIT $recordperpagina OFFSET 0";
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
                                                        echo "<div align=\"center\" id=\"ButtonBox$I\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_azienda']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteAzienda(".$row['id_azienda'].")\"></div>";
                                                    echo "</td>";                                                    
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                    
                                            }
                                            echo "</tbody></table></div>";
                                            $querycount = "SELECT COUNT(*) FROM azienda";
                                            $resultcount = $conn->query($querycount);
                                            $rowcount = $resultcount->fetch_assoc();
                                            $tuple = intval($rowcount['COUNT(*)']);
                                            $npagine = intval($tuple / $recordperpagina);
                                            if ($npagine * $recordperpagina < $tuple) $npagine += 1;
                                            echo "<div align=\"center\" id=\"pages\"><ul class=\"pagination pagination-lg\">";
                                            for ($I = 0;$I < $npagine;$I++)
                                            {
                                                $idtoprint = $I * $recordperpagina;
                                                echo "<li><a id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint, $idtoprint)\"> ".($I + 1)." </a></li>";
                                            }
                                            echo "</ul></div>";
                                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>