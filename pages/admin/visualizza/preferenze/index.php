<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Preferenze" );
    import("../../../../");
    $recordperpagina = (isset($_POST['custompreferenze'])) ? $_POST['custompreferenze'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['npreferenze'])) ? 10 : $_POST['npreferenze'];
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
    ?>
    
    <script src="scripts/script.js"> </script>
    
    <script>        
        function changePage(tupledastampare, offset, pagetounderline)
        {
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerPreferenza/ajaxGetTablePortion.php',
                data : { 'offset' : offset, 'tuple' : tupledastampare },
                cache : false,
                success : function (html)
                {
                    $("#tablepreferenze").html("Caricamento....");
                    $("#tablepreferenze").html("<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome azienda, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>");
                    $("#tablepreferenze").append(html);                   
                    $("#tablepreferenze").hide();
                    $("#tablepreferenze").fadeIn();
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
                <div class="panel" style="min-height: 0px">
                    <h1>Visualizza Preferenze</h1>    
                    
                    <?php
                            echo "<div align=\"right\"> Visualizza <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualcustomredirect\"> <input type=\"text\" id=\"customnum\" name=\"custompreferenze\"> </form>  <form style=\"display : inline\" action=\"index.php\" method=\"POST\" id=\"manualredirect\"><select name=\"npreferenze\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> aziende per pagina </form></div><br> ";
                            if (isset($_POST['npreferenze']))
                            {
                        ?>
                        <script>
                            var rightindex = 1;
                            $("#slc > option").each(function() {
                                if (this.text === '<?php echo intval($_POST['npreferenze']); ?>')
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
                        $Query = "SELECT * FROM preferenza ORDER BY nome LIMIT $recordperpagina OFFSET 0";
                        if ($result = $connessione->query ($Query))
                        {
                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table id=\"tablepreferenze\" class=\"table table-bordered\"><thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome della preferenza </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";
                                    echo "<label id=\"label".$I."\"> ".$row['nome']."</label> <input style=\"visibility:hidden\" type=\"button\" class = \"btn \" value=\"Modifica\">";
                                echo "</td>";
                                echo "<td>";
                                    echo "<div align=\"center\" id=\"ButtonBox$I\"> <input  class = \"btn btn-success\" name=\"".$row['id_preferenza']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"> <input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData($('#modifica".$I."').closest('input').attr('name'))\"> </div>";
                                echo "</td>";
                                echo "</tr>";
                                echo "</div>";
                                $I++;
                            }
                            echo "</tbody></table></div>";
                            $querycount = "SELECT COUNT(*) FROM preferenza";
                            $resultcount = $connessione->query($querycount);
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
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#customnum").css("height",parseInt($("#slc").height()));
        if ($(".active").length === 0)
            $("#pages").find("ul").children().first().addClass("active");
         
        $("select[name=\"npreferenze\"]").change(function (){
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
    close_html ("../../../../");
?>