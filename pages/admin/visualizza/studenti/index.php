<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Studenti" );
    import("../../../../");
    
    $idclasse = $_POST['id_classe'];
    $idanno = $_POST['years'];
    
    /*$recordperpagina = (isset($_POST['customnstud'])) ? $_POST['customnstud'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['nstud'])) ? 10 : $_POST['nstud'];
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
    <script src="scripts/script.js"> </script>
<!--    <script>
        
        function changePage(tupledastampare, offset, classe, pagetounderline)
        {
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerStudente/ajaxGetTablePortion.php',
                data : { 'offset' : offset, 'tuple' : tupledastampare, 'classe' : classe },
                cache : false,
                success : function (html)
                {
                    $("#tablestudenti").html("Caricamento....");
                    $("#tablestudenti").html("<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Modifica </th> <th style=\"text-align : center\"> Registro </th> <th style=\"text-align : center\"> Elimina </th> </thead>");
                    $("#tablestudenti").append(html);                   
                    $("#tablestudenti").hide();
                    $("#tablestudenti").fadeIn();
                    
                    $("#pages").find("ul").find("li").each(function (){
                        $(this).removeClass("active");
                    });
                    $("#"+pagetounderline).parent().addClass("active");
                    
                    $("form[target=\"_blank\"]").height($("#modifica0").height())
                }
            })
        }
    </script>    -->
    <div class="container">
        
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id = "mainPanel">
                    <h1>Visualizza Studenti</h1>    
                    <br>                      
                    <?php
                        $connessione = dbConnection("../../../../");
                        $Query = (isset($idclasse)) ? "SELECT * "
                                                             . "FROM utente AS u, studente AS s, studente_attends_classe AS sac "
                                                             . "WHERE sac.classe_id_classe = $idclasse "
                                                             . "AND sac.anno_scolastico_id_anno_scolastico = $idanno "
                                                             . "AND s.id_studente = sac.studente_id_studente "
                                                             . "AND u.id_utente = sac.studente_id_studente "
                                                             . "ORDER BY cognome "
                                : null;
                            
                        
                        if (null !== $Query  && $result = $connessione->query ($Query))
                        {
                            echo "<div class=\"row\">";
                            echo "<div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tablestudenti\" style=\"\">"
                            . "<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Modifica </th> <th style=\"text-align : center\"> Elimina </th> </thead> <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";                                
                                    echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td align=\"center\">";
                                    echo "<div id=\"ButtonBox".$I."\" align=\"center\">";
                                         echo "<input class = \"btn btn-success \" name=\"".$row['id_studente']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'), $idclasse, $idanno)\"></td> "
                                                 . "<td align=\"center\"><input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData(".$row['classe_id_classe'].",$('#modifica".$I."').closest('input').attr('name'))\"> </td>";
                                    echo "</div>";
                                echo "</tr>";
                                $I++;
                            }  
                            echo "</tbody></table></div>";
                            /*if (isset($idclasse))
                            {
                                $tuple = $result->num_rows;
                                $npagine = intval($tuple / $recordperpagina);
                                if ($npagine * $recordperpagina < $tuple) $npagine += 1;
                                echo "<div align=\"center\" id=\"pages\"><ul class=\"pagination pagination-lg\">";
                                for ($I = 0;$I < $npagine;$I++)
                                {
                                    $idtoprint = $I * $recordperpagina;
                                    echo "<li><a id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint, $idclasse, $idtoprint, $idtoprint)\"> ".($I + 1)." </a></li>";
                                }
                                echo "</ul></div>";
                            }*/
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<!--    <script>
        $("#customnum").css("height",parseInt($("#slc").height()));
        if ($(".active").length === 0)
            $("#pages").find("ul").children().first().addClass("active");
        
        $("select[name=\"nstud\"]").change(function (){
            $("#manualredirect").submit();
        });
        
        $("#customnum").keyup(function (e){
            if (e.which === 13){
                $("#manualcustomredirect").submit();
            }
        });
        
        $("form[target=\"_blank\"]").height($("#modifica0").height());
        
        function redirectForClass(progressiv){
            $("#classform"+progressiv).submit();
        }
    </script>
        -->
</body>
    
<?php
    close_html ("../../../../");
?>