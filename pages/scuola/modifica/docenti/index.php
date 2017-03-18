<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Visualizza Docenti" );
    import("../../../../");
    /*$recordperpagina = (isset($_POST['customdocente'])) ? $_POST['customdocente'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['ndocenti'])) ? 10 : $_POST['ndocenti'];
    }
    if ($recordperpagina <= 0) $recordperpagina = 1;*/
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
    ?>
    <script src="scripts/scripts.js"></script>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Visualizza Docenti</h1>
                    <br>                      
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
                                <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php echo $recordperpagina ?>">
                            </div>
                        </div>
                    </div>    
                    <br>
                                        <?php   /*
                                        echo "<div align=\"right\"> <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualcustomredirect\"> Visualizza <input type=\"text\" id=\"customnum\" name=\"customdocente\"> </form>  <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualredirect\"> <select name=\"ndocenti\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> aziende per pagina </form></div><br>  ";
                                            if (isset($_POST['ndocenti']))
                                            {
                                        ?>
                    <script>
                        var rightindex = 1;
                        $("#slc > option").each(function() {
                            if (this.text === '<?php echo intval($_POST['ndocenti']); ?>')
                            rightindex = this.index;
                                
                            $("#slc").prop('selectedIndex', rightindex);
                        });
                    </script>      
                                      <?php }
                                            else 
                                            { ?> 
                    <script> $("#slc").prop('selectedIndex', 1); </script> 
                                      <?php }   */
                                            $conn = dbConnection("../../../../");
                                            $query = "SELECT * FROM utente, docente WHERE id_docente = id_utente AND id_docente != ".$_SESSION['userId']." ORDER BY cognome";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            echo "<div class=\"table-responsive\"><table id=\"tabledocenti\" class=\"table table-bordered\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"width:2%; text-align : center\"> <input id=\"checkall\" type=\"checkbox\"> </th> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                                            if($result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td><input class=\"singlecheck\" type=\"checkbox\"></td><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<div align=\"center\" id=\"ButtonBox$I\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_docente']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteDocente(".$row['id_docente'].")\"></div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                    
                                            }
                                            echo "</tbody></table></div>";
                                            /*$querycount = "SELECT COUNT(*) FROM docente";
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
                                            echo "</ul></div>";*/
                                                
                                        ?>
                </div>
            </div>
        </div>
    </div>
<!--    <script>
        $("#customnum").css("height",parseInt($("#slc").height()));
        if ($(".active").length === 0)
            $("#pages").find("ul").children().first().addClass("active");
                
        $("select[name=\"ndocenti\"]").change(function (){
            $("#manualredirect").submit();
        });
            
        $("#customdocente").keyup(function (e){
            if (e.which === 13){
                $("#manualcustomredirect").submit();
            }
        });
            
        $("form[target=\"_blank\"]").height($("#modifica0").height());
    </script>-->
</body>
<?php
    close_html ("../../../../");
?>