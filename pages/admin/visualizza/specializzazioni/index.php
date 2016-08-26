<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Visualizza Specializzazioni" );
    import("../../../../");
    $recordperpagina = (isset($_POST['customspec'])) ? $_POST['customspec'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['nspec'])) ? 10 : $_POST['nspec'];
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
        topNavbar ("../../../../");
        titleImg ("../../../../");
        printChat("../../../../");
    ?>
    
    <script src="scripts/script.js"> </script>
    
    <script>
        function changePage(tupledastampare, offset, pagetounderline)
        {
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerSpecializzazione/ajaxGetTablePortion.php',
                data : { 'offset' : offset, 'tuple' : tupledastampare },
                cache : false,
                success : function (html)
                {
                    $("#tablespec").html("Caricamento....");
                    $("#tablespec").html("<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome azienda, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>");
                    $("#tablespec").append(html);                   
                    $("#tablespec").hide();
                    $("#tablespec").fadeIn();
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
                <div class="panel" style="min-height: 0px">
                    <h1>Visualizza Specializzazioni</h1>    
                    
                    <?php
                    echo "<div align=\"right\"> Visualizza  <form style=\"display:inline\" action=\"index.php\" method=\"POST\" id=\"manualcustomredirect\"> <input type=\"text\" id=\"customnum\" name=\"customspec\"> </form> <form style=\"display:inline\" action=\"index.php\" method=\"POST\" id=\"manualredirect\"> <select name=\"nspec\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> aziende per pagina </form></div><br> ";
                            if (isset($_POST['nspec']))
                            {
                        ?>
                    <script>
                        var rightindex = 1;
                        $("#slc > option").each(function() {
                            if (this.text === '<?php echo intval($_POST['nspec']); ?>')
                            rightindex = this.index;
                                
                            $("#slc").prop('selectedIndex', rightindex);
                        });
                    </script>      
                      <?php }
                            else 
                            { ?> 
                    <script> $("#slc").prop('selectedIndex', 1); </script> 
                      <?php }
                        $connessione = dbConnection("../../../../");
                        $Query = "SELECT * FROM specializzazione ORDER BY nome LIMIT $recordperpagina OFFSET 0";
                        if ($result = $connessione->query ($Query))
                        {
                            echo "<div class=\"row\"> <div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table id=\"tablespec\" class=\"table table-bordered\"><thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome della specializzazione </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";
                                    echo "<label id=\"label".$I."\"> ".$row['nome']."     </label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                
                                echo "<td>";
                                     echo "<div align=\"center\" id=\"ButtonBox$I\"> <input class = \"btn btn-success\" name=\"".$row['id_specializzazione']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"> <input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData($('#modifica".$I."').closest('input').attr('name'))\"> </div>";
                                echo "</td>";
                                $I++;
                            }
                            
                            echo "</tbody></table></div>";
                            $querycount = "SELECT COUNT(*) FROM specializzazione";
                            $resultcount = $connessione->query($querycount);
                            $rowcount = $resultcount->fetch_assoc();
                            $tuple = intval($rowcount['COUNT(*)']);
                            $npagine = intval($tuple / $recordperpagina);
                            if ($npagine * $recordperpagina < $tuple) $npagine += 1;
                            echo "<div align=\"center\" id=\"pages\">";
                            for ($I = 0;$I < $npagine;$I++)
                            {
                                $idtoprint = $I * $recordperpagina;
                                echo "<a style=\"font-size:25px; margin-right:20px; text-decoration:none\" id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint,$idtoprint)\"> ".($I + 1)." </a>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }     
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#customnum").css("height",parseInt($("#slc").height()));
        var found = false;
        var dio = $("#pages").children();
        for (I = 0;I < dio.length;I++)
            if(dio[I].style.fontSize === '35px')
                found = true;
                
        if (!found) 
            $("#pages").children().first().css("font-size","35px");
                
        $("select[name=\"nspec\"]").change(function (){
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
    close_html ();
?>