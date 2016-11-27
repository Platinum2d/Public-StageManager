<?php
    include '../../functions.php';
    checkLogin ( ceoType , "../../../");
    open_html ( "Visualizza Tutor" );
    import("../../../");
    $recordperpagina = (isset($_POST['customtutor'])) ? $_POST['customtutor'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['ntutor'])) ? 10 : $_POST['ntutor'];
    }
    if ($recordperpagina <= 0) $recordperpagina = 1;
?>
<body>
    <style>
        .minw{
            width: 65%;
        }
    </style>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <script src="scripts/scripts.js"> </script>
        
    <!-- Begin Body -->
    <script>
        
        function changePage(tupledastampare, offset, pagetounderline)
        {
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerTutor/ajaxGetTablePortion.php',
                data : { 'offset' : offset, 'tuple' : tupledastampare },
                cache : false,
                success : function (html)
                {
                    $("#tabletutor").html("Caricamento....");
                    $("#tabletutor").html("<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>");
                    $("#tabletutor").append(html);                   
                    $("#tabletutor").hide();
                    $("#tabletutor").fadeIn();
                    $("#pages").find("ul").find("li").each(function (){
                        $(this).removeClass("active");
                    });
                    $("#"+pagetounderline).parent().addClass("active");
                    $("form[target=\"_blank\"]").height($("#modifica0").height())
                }
            })
        }
    </script>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Visualizza Tutor</h1> 
                                        <?php
                                            echo "<div align=\"right\"> <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualcustomredirect\"> Visualizza <input type=\"text\" id=\"customnum\" name=\"customtutor\">  </form> <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualredirect\"><select name=\"ntutor\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> tutor per pagina </form></div> ";
                                            if (isset($_POST['ntutor']))
                                            {
                                        ?>
                    <script>
                        var rightindex = 1;
                        $("#slc > option").each(function() {
                            if (this.text === '<?php echo intval($_POST['ntutor']); ?>')
                            rightindex = this.index;
                            
                            $("#slc").prop('selectedIndex', rightindex);
                        });
                    </script>      
                                      <?php }
                                            else 
                                            { ?> 
                    <script> $("#slc").prop('selectedIndex', 1); </script> 
                                      <?php }
                                          
                                            $conn = dbConnection("../../../");
                                            $query = "SELECT * FROM utente, tutor WHERE id_utente = id_tutor AND azienda_id_azienda = ".$_SESSION['userId']." ORDER BY cognome LIMIT $recordperpagina OFFSET 0";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            if($result->num_rows > 0)
                                            {
                                                echo "<br><div class=\"table-responsive\"><table id=\"tabletutor\" class=\"table table-bordered\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo "<div id=\"ButtonBox$I\" align=\"center\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_tutor']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteTutor(".$row['id_tutor'].")\"> <br></div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                echo "</tbody></table></div>";
                                                $querycount = "SELECT COUNT(*) FROM tutor WHERE azienda_id_azienda = ".$_SESSION['userId']."";
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
                                            }
                                            echo "</div>";
                                                
                                            echo "</div>";
                                        ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#customnum").css("height",parseInt($("#slc").height()));
        if ($(".active").length === 0)
            $("#pages").find("ul").children().first().addClass("active");
        
        $("select[name=\"ntutor\"]").change(function (){
            $("#manualredirect").submit();
        });
        
        $("#customnum").keyup(function (e){
            if (e.which === 13){
                $("#manualcustomredirect").submit();
            }
        });
        
        $("form[target=\"_blank\"]").height($("#modifica0").height());
    </script>
</body>
<?php
    close_html ("../../../");
?>