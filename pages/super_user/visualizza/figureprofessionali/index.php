<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Figure professionali" );
    import("../../../../");
    $conn = dbConnection("../../../../");
?>
<body>
 	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    
    <script src="scripts/script.js"></script>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Visualizza Figure Professionali</h1>
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
                        
                    <table id="annitable" class="table table-bordered">
                        <thead style="background : #eee; font-color : white">
                        <th style="text-align : center"> <input type="checkbox" id="checkall"> </th>
                        <th style="text-align : center"> Figura professionale </th>
                        <th style="text-align : center; width: 25%"> Azioni </th>
                        </thead>
                            
                        <tbody style="text-align : center">
                            <?php
                                $query = "SELECT * FROM figura_professionale ORDER BY nome";
                                    
                                $result = $conn->query($query);
                                $I=0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $nome = $row['nome'];
                                    $id = $row['id_figura_professionale'];
                                        
                                    echo "<tr id=\"figura$I\"><td><input class=\"singlecheck\" type=\"checkbox\"></td><td contenteditable=\"true\" oninput=\"$(this).css('color', 'red')\"> $nome </td> ";                                                                        
                                    echo "<td> <button id=\"modifica$I\" type=\"button\" class=\"btn btn-success btn-sm margin buttonfix\" onclick=\"sendData($I, $id)\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>"
                                            . " <button onclick=\"editSettori($id)\" class=\"btn btn-info\"><span class=\"glyphicon glyphicon-info-sign\"> </span>  Settori</button></td>";
                                                
                                    echo "</tr>";
                                    $I++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAddSettore(id_figura_professionale)
        {
            var modal = $("#SuperAlert").find(".modal-body");
            
            if ($("#addSector").length <= 0)
            {
                modal.find("table").append("<tr id='addSector'> \n\
                        <td><select onchange='updateSectorSettore()' class='form-control' id='addSectorIndirizzo'> </select></td>\n\
                        <td><select class='form-control' id='addSectorSettore'> </select></td>\n\
                        <td align='center'><button id='addSectorConfirm' class='btn btn-success btn-sm margin buttonfix'><span class=\"glyphicon glyphicon-ok\"> </span></button></td>\n\
                    </tr>");
                                    
                                    $.ajax({
                                        type : 'POST',
                                        url : '../../inserimento/figureprofessionali/ajaxOpsPerFiguraProfessionale/ajaxIndirizzi.php',
                                        cache : false,
                                        success : function (xml)
                                        {
                                            $(xml).find("indirizzo").each(function (){
                                                var indirizzo = $(this).text();
                                                $("#addSectorIndirizzo").append("<option>"+indirizzo+"</option>")
                                            });
                                            updateSectorSettore();
                                        }
                                    });
                                    
                                    $("#addSectorConfirm").on("click", function (){
                                        $.ajax({
                                            type : 'POST',
                                            url : 'ajaxOpsPerFiguraProfessionale/ajaxAddSettore.php',
                                            data : {'figura' : id_figura_professionale, 'settore' : $("#addSectorSettore").val()},
                                            cache : false,
                                            success : function (msg)
                                            {
                                                if (msg === "ok")
                                                {
                                                    var indirizzo = $("#addSectorIndirizzo").find(":selected").val();
                                                    var settore = $("#addSectorSettore").find(":selected").text();
                                                    
                                                    $("#SuperAlert").find(".modal-body").find("tbody").append("<tr> <td align='center'>"+indirizzo+"</td> <td align='center'>"+settore+"</td> <td></td> </tr>")
                                                    
                                                    $("#addSectorIndirizzo").parents("tr").fadeOut();
                                                }
                                            }
                                        });
                                    });
                                }
                            }
                            
                            function updateSectorSettore()
                            {
                                $.ajax({
                                    type : 'POST',
                                    url : '../../inserimento/figureprofessionali/ajaxOpsPerFiguraProfessionale/ajaxSettori.php',
                                    data : {'indirizzo' : $("#addSectorIndirizzo").find(":selected").val()},
                                    cache : false,
                                    success : function (xml)
                                    {            
                                        $("#addSectorSettore").html("");
                                        $(xml).find("settori").find("settore").each(function (){
                                            var id = $(this).find("id").text();
                                            var nome = $(this).find("nome").text();
                                            
                                            $("#addSectorSettore").append("<option value='"+id+"'>"+nome+"</option>");
                                        });
                                    }
                                });
                            }
                            
                            function editSettori(id_figura_professionale)
                            {
                                $.ajax({
                                    type : 'POST',
                                    url : 'ajaxOpsPerFiguraProfessionale/ajaxSettori.php',
                                    cache : false,
                                    data : { 'idfigura' : id_figura_professionale },
                                    success : function (xml)
                                    {
                                        var modal = $("#SuperAlert").find(".modal-body");
                                        $("#SuperAlert").find(".modal-title").html("Settori associati");
                                        
                                        modal.html("<div align='center'><a style='color:#828282' href='javascript:openAddSettore("+id_figura_professionale+")'><span style='color:green' class='glyphicon glyphicon-plus'></span>   Aggiungi</a></div><br>");
                                        modal.append("<table class='table table-bordered'><thead><th style='text-align : center'>Indirizzo di studi</th><th style='text-align : center'>Settore</th><th style='text-align : center'>Azioni</th></thead><tbody></tbody></table>");
                                        $(xml).find("settori").find("settore").each(function (){
                                            var id = $(this).find("id").text();
                                            var id_ass = $(this).find("id_associazione").text();
                                            var indirizzo = $(this).find("indirizzo_studi").text();
                                            var settore = $(this).find("nome_settore").text();
                                            
                                            modal.find("tbody").append("<tr name='"+id+"'>\n\
                                    <td align='center'>"+indirizzo+"</td>\n\
                                    <td align='center'>"+settore+"</td>\n\
                                    <td align='center'> <button onclick = 'deleteSettori("+id_ass+")' class='btn btn-danger btn-sm margin'><span class=\"glyphicon glyphicon-remove\"> </span></button> </td>\n\
                                </tr>");
                                                    });
                                                    $("#SuperAlert").modal("show");
                                                }
                                            });
                                        }
                                        
                                        function deleteSettori(id_associazione)
                                        {
                                            $.ajax({
                                                type : 'POST',
                                                url : 'ajaxOpsPerFiguraProfessionale/ajaxEliminaSettore.php',
                                                cache : false,
                                                data : { 'id' : id_associazione },
                                                success : function (msg)
                                                {
                                                    if (msg === "ok")
                                                    {
                                                        $("button[onclick = 'deleteSettori("+id_associazione+")']").parents("tr").fadeOut();
                                                    }
                                                }
                                            });
                                        }
    </script>
</body>
    
<?php
    close_html ("../../../../");
?>