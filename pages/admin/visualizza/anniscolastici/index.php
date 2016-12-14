<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Anni Scolatici" );
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
                    <h1>Visualizza Anni Scolastici</h1>
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
                        
                    <table id="annitable" class="table table-bordered">
                        <thead style="background : #eee; font-color : white">
                        <th style="text-align : center"> Nome dell'anno scolastico </th>
                        <th style="text-align : center"> Corrente </th>
                        <th style="text-align : center; width: 25%"> Azioni </th>
                        </thead>
                            
                        <tbody style="text-align : center">
                            <?php
                                $query = "SELECT * FROM anno_scolastico ORDER BY corrente DESC";
                                    
                                $result = $conn->query($query);
                                $I=0;
                                $firstIndex = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $nome = $row['nome_anno'];
                                    $corrente = (intval($row['corrente']) === 1) ? "true" : "false";
                                    $id = $row['id_anno_scolastico'];
                                        
                                    echo "<tr id=\"anno$I\"><td contenteditable=\"true\" oninput=\"$(this).css('color', 'red')\"> $nome </td> <td> <input class=\"currentcheckbox\" type=\"checkbox\" ";
                                    if ($corrente === "true") {$firstIndex = $I; echo "checked=\"$corrente\" onchange=\"checkInput(this, $firstIndex)\"> </td>";}
                                    else echo "onchange=\"checkInput(this, $firstIndex)\" ></td>";
                                        
                                    echo "<td> <button id=\"modifica$I\" type=\"button\" class=\"btn btn-success btn-sm margin buttonfix\" onclick=\"sendData($I, $id)\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>"
                                            . " </td>";
                                                
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
</body>
    
<?php
    close_html ("../../../../");
?>