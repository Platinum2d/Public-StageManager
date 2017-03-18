<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Settori" );
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
                    <h1>Visualizza Settori</h1>
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
                                <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="">
                            </div>
                        </div>
                    </div>    
                    <br>
                        
                    <table id="settori" class="table table-bordered">
                        <thead style="background : #eee; font-color : white">
                        <th style="text-align : center"> <input type="checkbox" id="checkall"> </th>    
                        <th style="text-align : center"> Indirizzo di studi </th>
                        <th style="text-align : center"> Nome Settore </th>
                        <th style="text-align : center; width: 25%"> Azioni </th>
                        </thead>
                            
                        <tbody style="text-align : center">
                            <?php
                                $query = "SELECT * FROM settore ORDER BY indirizzo_studi, nome_settore DESC";
                                    
                                $result = $conn->query($query);
                                $I=0;
                                $firstIndex = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $id = $row['id_settore'];
                                    $indirizzo = $row['indirizzo_studi'];
                                    $settore = $row['nome_settore'];                                    
                                        
                                    echo "<tr id=\"settore$I\"><td> <input class=\"singlecheck\" type=\"checkbox\"> </td>"
                                    . "<td name='indirizzo' contenteditable=\"true\" oninput=\"$(this).css('color', 'red')\"> $indirizzo </td>";
                                    echo "<td name='settore' contenteditable=\"true\" oninput=\"$(this).css('color', 'red')\">$settore</td>";
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