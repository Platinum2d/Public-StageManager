<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Visualizza Aziende" );
    import("../../../../");
    $recordperpagina = (!isset($_POST['naziende'])) ? 10 : $_POST['naziende'];
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
    
    <!-- Begin Body -->
    <script>
            
        function changePage(tupledastampare, offset, pagetounderline)
        {
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerAzienda/ajaxGetTablePortion.php',
                data : { 'offset' : offset, 'tuple' : tupledastampare },
                cache : false,
                success : function (html)
                {
                    $("#tableaziende").html("Caricamento....");
                    $("#tableaziende").html("<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome azienda, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>");
                    $("#tableaziende").append(html);                   
                    $("#tableaziende").hide();
                    $("#tableaziende").fadeIn();
                    $("#pages > a").css("font-size","25px");
                    $("#"+pagetounderline).css("font-size","35px");
                    $("form[target=\"_blank\"]").height($("#modifica0").height())
                }
            })
        }
    </script>
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="panel" id="mainPanel" style="min-height: 0px">
					<h1>Visualizza Aziende</h1> 
                                        
                                        <?php
                                            echo "<div align=\"right\"> <form action=\"index.php\" method=\"POST\" id=\"manualredirect\">Visualizza <select name=\"naziende\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> aziende per pagina </form></div> ";
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
                                            $conn = dbConnection("../../../../");
                                            $query = "SELECT * FROM azienda ORDER BY username LIMIT $recordperpagina OFFSET 0";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            echo "<br><div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tableaziende\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome azienda, Username  </th> <th style=\"text-align : center\"> Azioni </th></thead> <tbody>";
                                            if($result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['nome_aziendale']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
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
                                            $npagine = intval($tuple / $recordperpagina) + 1;
                                            echo "<div align=\"center\" id=\"pages\">";
                                            for ($I = 0;$I < $npagine + 1;$I++)
                                            {
                                                $idtoprint = $I * $recordperpagina;
                                                echo "<a style=\"font-size:25px; margin-right:20px; text-decoration:none\" id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint,$idtoprint)\"> ".($I + 1)." </a>";
                                            }
                                            
                                            echo "</div>";
                                            
                                            echo "</div>";
                                        ?>
				</div>
			</div>
		</div>
	</div>
        <script>
            var found = false;
            var dio = $("#pages").children();
            for (I = 0;I < dio.length;I++)
                if(dio[I].style.fontSize === '35px')
                    found = true;

            if (!found) 
                $("#pages").children().first().css("font-size","35px");

            $("select[name=\"naziende\"]").change(function (){
                $("#manualredirect").submit();
            });
            $("form[target=\"_blank\"]").height($("#modifica0").height());
        </script>
</body>
<?php
    close_html ();
?>