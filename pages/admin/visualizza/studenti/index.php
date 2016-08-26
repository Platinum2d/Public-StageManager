<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Visualizza Studenti" );
    import("../../../../");
//    echo "<link rel=\"stylesheet\" href=\"Chat/style.css\">";
//    echo "<script src=\"Chat/chat.js\"> </script>";
    $recordperpagina = (isset($_POST['customnstud'])) ? $_POST['customnstud'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['nstud'])) ? 10 : $_POST['nstud'];
    }
    if ($recordperpagina <= 0) $recordperpagina = 1;
?>
<body>
<!--    <script>
        if (typeof(Storage) !== "undefined") {
            alert("supported")
        }
        else
        {
            alert("not supported")
        }
    </script>-->
    
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
    
<!--    <div id="wholechat">
        <div id="chat" onclick="fillChat()" class="chat-container">
            <p id="nascondi" class="hide-show-p"><a id="nascondilink" href="javascript:hideChat()" class="hide-show-link"> Chat </a></p>
            <div id='chatcontent'>
            </div>
        </div>
    </div>-->
        
    <script>
    if (typeof(localStorage.chatCode) !== "undefined"){
        $("#wholechat").html(localStorage.chatCode);
    }
    </script>
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
                    $("#tablestudenti").html("<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Modifica </th> <th style=\"text-align : center\"> Registro </th> <th style=\"text-align : center\"> Elimina </th> </thead>");
                    $("#tablestudenti").append(html);                   
                    $("#tablestudenti").hide();
                    $("#tablestudenti").fadeIn();
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
                <div class="panel" id = "mainPanel">
                    <h1>Visualizza Studenti</h1>    
                    <br>
                    <ul id="classes" class="nav nav-tabs">
     							<?php
                                                        $conn = dbConnection("../../../../");
                                    $ClasseSelezionata = (isset($_POST['idclasse'])) ? $_POST['idclasse'] : null;
                                    $query = "SELECT  `nome`, `id_classe` FROM  `classe` ";
                                    $result1 = $conn->query ( $query );
                                    $I=0;
                                    while ( $row = $result1->fetch_assoc () ) {
                                        $nome = $row ['nome'];
                                        $idclasse = $row ['id_classe'];
                                        echo "<form action=\"index.php\" method=\"POST\" id=\"classform$I\"> <input type=\"hidden\" name=\"idclasse\" value=\"$idclasse\">  </form>";
                                        echo "<li>
                                                <a class='navbar-brand' href='javascript:redirectForClass($I)'>
                                                    <input type='hidden' value='$idclasse' class='classe_id'/>
                                                    $nome
                                                </a>
                                            </li>";
                                        $I++;
                                    }
                                ?>
                    </ul>
                    <?php 
                    if (isset($_POST['idclasse']))
                    {
                            echo "<br><div align=\"right\"> <form action=\"index.php\" method=\"POST\" id=\"manualredirect\">Visualizza <input type=\"text\" id=\"customnum\" name=\"customnstud\"> <select name=\"nstud\" id=\"slc\"> <option> 5 </option> <option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option> </select> studenti per pagina <input type=\"hidden\" name=\"idclasse\" value=\"".$_POST['idclasse']."\"></form></div><br> ";
                            if (isset($_POST['nstud']))
                            {
                    ?>
                                    <script>
                                        var rightindex = 1;
                                        $("#slc > option").each(function() {
                                            if (this.text === '<?php echo intval($_POST['nstud']); ?>')
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
                    
                    <?php
                        $connessione = dbConnection("../../../../");
                        $Query = (!isset($_POST['idclasse'])) ? null : "SELECT * FROM studente WHERE classe_id_classe = $ClasseSelezionata ORDER BY cognome LIMIT $recordperpagina OFFSET 0";
                            
                        if ($Query !== null && $result = $connessione->query ($Query))
                        {
                           
                            echo "<div class=\"row\">";
                            echo "<div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tablestudenti\" style=\"\">"
                            . "<thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Modifica </th> <th style=\"text-align : center\"> Registro </th> <th style=\"text-align : center\"> Elimina </th> </thead> <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";                                
                                    echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td align=\"center\">";
                                    echo "<div id=\"ButtonBox".$I."\" align=\"center\">";
                                         echo "<input class = \"btn btn-success \" name=\"".$row['id_studente']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"></td> "
                                                 . "<td align=\"center\"><form target=\"_blank\" method=\"POST\" action=\"registro/index.php\"> <input type=\"hidden\" name=\"idstudente\" value=\"".$row['id_studente']."\">  <input type=\"hidden\" name=\"nome\" value=\"".$row['nome']."\">"
                                                 . "<input type=\"hidden\" name=\"cognome\" value=\"".$row['cognome']."\">"
                                                 . "<input class=\"btn btn-info\" type=\"submit\" value=\"Registro\"  id=\"registro".$I."\"> </form></td>"
                                                 . "<td align=\"center\"><input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData(".$row['classe_id_classe'].",$('#modifica".$I."').closest('input').attr('name'))\"> </td>";
                                    echo "</div>";
                                echo "</tr>";
                                $I++;
                            }
                                
                            echo "</tbody></table></div>";
                            
                            if (isset($_POST['idclasse']))
                            {
                                $querycount = "SELECT COUNT(*) FROM studente WHERE classe_id_classe = ".$_POST['idclasse']."";
                                $resultcount = $connessione->query($querycount);
                                $rowcount = $resultcount->fetch_assoc();
                                $tuple = intval($rowcount['COUNT(*)']);
                                $npagine = intval($tuple / $recordperpagina);
                                if ($npagine * $recordperpagina < $tuple) $npagine += 1;
                                
                                echo "<div align=\"center\" id=\"pages\">";
                                for ($I = 0;$I < $npagine;$I++)
                                {
                                    $idtoprint = $I * $recordperpagina;
                                    echo "<a style=\"font-size:25px; margin-right:20px; text-decoration:none\" id=\"$idtoprint\" href=\"javascript:changePage($recordperpagina,$idtoprint, ".$_POST['idclasse'].",$idtoprint)\"> ".($I + 1)." </a>";
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
            
            $("#customnum").keyup(function (e){
                if (e.which === 13){
                    $("#manualredirect").submit();
                }
            });
            
            $("form[target=\"_blank\"]").height($("#modifica0").height());
            
            function redirectForClass(progressiv){
                $("#classform"+progressiv).submit();
            }
    </script>
        
</body>

<?php
    close_html ();
?>