<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Visualizza Studenti" );
    import("../../../../");
    $recordperpagina = (!isset($_GET['nstud'])) ? 10 : $_GET['nstud'];
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
    
    <script>
        $(document).ready(function() {
            var winheight = $(window).height() - $(".navbar-nav").height() - 30;
            $("#chat").css("max-height",winheight+"px")            
        })
        
        function hideChat()
        {            
            if ($('#nascondilink').html() !== ' Chat ')
            {
                $('#chatcontent').html('')
                $("#chat").css('opacity','0.4')
                $("#nascondilink").html(' Chat ');
            }
        }
        
        function fillChat()
        {
            if ($('#nascondilink').html() === ' Chat ')
            {
                $("#chat").css('opacity',1)
                $("#nascondilink").html('Nascondi')
                $.ajax({
                    type : 'POST',
                    url : '/pages/admin/inserimento/studenti/ajaxOpsPerStudente/ajaxAzienda.php',
                    cache : false,
                    success : function (xml){
                        $(xml).find('aziende').find('azienda').each(function () {
                            $("#chatcontent").append("<p style=\"color:black;padding-left: 5px; padding-right: 5px; padding-bottom:10px;padding-top:10px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px; color:white\"> "+$(this).find('nome').text()+" </p>")
                        })
                    }
                })
            }
        }
    </script>
        
<!--    <div id="chat" onclick="fillChat()" style="position :fixed; min-width: 0px; background: #ff3333; min-height: 50px; width: 200px; bottom: 0px; z-index: 10000; opacity: 0.4; overflow-y: scroll;"> 
        <p id="nascondi" style="color:black;padding-left: 5px; padding-right: 5px; padding-bottom:10px;padding-top:10px; font-size:12px"><a id="nascondilink" href="javascript:hideChat()" style='color:black; font-family: Helvetica Neue, Helvetica, Arial, sans-serif;'> Chat </a></p>
        <div id='chatcontent'>            
        </div>
    </div>-->
        
        
    <script src="scripts/script.js"> </script>
    <script>
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
                    $("#tablestudenti").html(html);
                    $("#tablestudenti").hide();
                    $("#tablestudenti").fadeIn();
                    $("#pages > a").css("font-size","25px");
                    $("#"+pagetounderline).css("font-size","35px");
                }
            })
        }
    </script>    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id = "mainPanel">
                    <h1>Visualizza Studenti</h1>    
                    <br>
                    <ul id="classes" class="nav nav-tabs">
     							<?php
                                                        $conn = dbConnection("../../../../");
                                    $ClasseSelezionata = (isset($_GET['idclasse'])) ? $_GET['idclasse'] : null;
                                    $query = "SELECT  `nome`, `id_classe` FROM  `classe` ";
                                    $result1 = $conn->query ( $query );
                                    while ( $row = $result1->fetch_assoc () ) {
                                        $nome = $row ['nome'];
                                        $idclasse = $row ['id_classe'];
                                        echo "<li>
                                                <a class='navbar-brand' href='index.php?idclasse=$idclasse'>
                                                    <input type='hidden' value='$idclasse' class='classe_id'/>
                                                    $nome
                                                </a>
                                            </li>";
                                    }
                                ?>
                    </ul> <br>
                    <?php 
                    if (isset($_GET['idclasse']))
                    {
                            echo "<div align=\"right\"> <form action=\"index.php\" method=\"GET\" id=\"manualredirect\">Visualizza <select name=\"nstud\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> Studenti per pagina <input type=\"hidden\" name=\"idclasse\" value=\"".$_GET['idclasse']."\"></form></div> ";
                            if (isset($_GET['nstud']))
                            {
                    ?>
                                    <script>
                                        var rightindex = 1;
                                        $("#slc > option").each(function() {
                                            if (this.text === '<?php echo intval($_GET['nstud']); ?>')
                                                rightindex = this.index;

                                            $("#slc").prop('selectedIndex', rightindex);
                                        });
                                    </script>      
                    <?php }
                            else 
                            { ?> 
                                    <script> $("#slc").prop('selectedIndex', 1); </script> 
                      <?php }
                    }?>
                    
                    <br><br>
                    <?php
                        $connessione = dbConnection("../../../../");
                        $Query = (!isset($_GET['idclasse'])) ? null : "SELECT * FROM studente WHERE classe_id_classe = $ClasseSelezionata ORDER BY cognome LIMIT $recordperpagina OFFSET 0";
                            
                        if ($Query !== null && $result = $connessione->query ($Query))
                        {
                           
                            echo "<div class=\"row\">";
                            echo "<div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tablestudenti\" style=\"\"> <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";                                
                                    echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<div id=\"ButtonBox".$I."\" align=\"center\">";
                                         echo "<input class = \"btn btn-success \" name=\"".$row['id_studente']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"> <input class=\"btn btn-info\" type=\"button\" value=\"Registro\" onclick=\"openRegistro('registro$I',".$row['id_studente'].")\" id=\"registro".$I."\"> <input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData(".$row['classe_id_classe'].",$('#modifica".$I."').closest('input').attr('name'))\"> ";
                                    echo "</div>";
                                echo "</td></tr>";
                                $I++;
                            }
                                
                            echo "</tbody></table></div>";
                            
                            if (isset($_GET['idclasse']))
                            {
                                $querycount = "SELECT COUNT(*) FROM studente WHERE classe_id_classe = ".$_GET['idclasse']."";
                                $resultcount = $connessione->query($querycount);
                                $rowcount = $resultcount->fetch_assoc();
                                $tuple = intval($rowcount['COUNT(*)']);
                                $npagine = intval($tuple / $recordperpagina) + 1;
                                //echo $npagine . " = ".$tuple." / ".$recordperpagina;
                                echo "<div align=\"center\" id=\"pages\">";
                                for ($I = 0;$I < $npagine + 1;$I++)
                                {
                                    $idtoprint = $I * $recordperpagina;
                                    echo "<a style=\"font-size:25px; margin-right:20px; text-decoration:none\" id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint, ".$_GET['idclasse'].",$idtoprint)\"> ".($I + 1)." </a>";
                                }
                                echo "</div>";
                            }
                        }
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
            
            $("select[name=\"nstud\"]").change(function (){
                $("#manualredirect").submit();
                
            });
    </script>
        
</body>

<?php
    close_html ();
?>