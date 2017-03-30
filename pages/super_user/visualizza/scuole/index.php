<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Scuole" );
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
                    <h1>Visualizza Scuole</h1>
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
                                <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php //echo $recordperpagina ?>">
                            </div>
                        </div>
                    </div>    
                    <br>
                    
                    <table id="annitable" class="table table-bordered">
                        <thead style="background : #eee; font-color : white">
                        <th style="text-align : center"> <input type="checkbox" id="checkall"> </th>
                        <th style="text-align : center"> Nome della scuola </th>
                        <th style="text-align : center; width: 35%"> Azioni </th>
                        </thead>
                        
                        <tbody>
                            <?php
                                $query = "SELECT id_scuola, nome FROM scuola ORDER BY nome";
                                $result = $conn->query($query);
                                    
                                $I = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $id = $row['id_scuola'];
                                    $nome = $row['nome'];
                                        
                                    echo "<tr id=\"scuola$I\">";
                                        echo "<td align=\"center\"><input class=\"singlecheck\" type=\"checkbox\"></td><td style=\"text-align : center\"> $nome </td> <td style=\"text-align : center\"> <button id=\"modifica$I\" class=\"btn btn-success\" value=\"Modifica\" onclick=\"openEdit($I, $id)\">Modifica</button>   <button class=\"btn btn-danger\" value=\"Elimina\" onclick=\"deleteSchool($I, $id)\">Elimina</button></td>";
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