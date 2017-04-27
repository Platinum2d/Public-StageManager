<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Visualizza stage" );
    import("../../../../");
    $conn = dbConnection("../../../../");
?>
<body>
 	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    
    <script src="scripts/script.js?5"></script>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Modifica Periodi di stage</h1>
                    <br>                         
                    <br>
                    
                    <div class="row">
                        <div class="col col-sm-2">
                            
                        </div>
                        
                        <div class="col col-sm-8">
                            <table id="stagetable" class="table table-bordered">
                                <thead style="background : #eee; font-color : white">
                                <th style="text-align : center; width: 33%"> Inizio </th>
                                <th style="text-align : center; width: 33%"> Fine </th>
                                <th style="text-align : center; width: 33%"> Azioni </th>
                                </thead>
                                
                                <tbody style="text-align : center">
                            <?php
                                $query = "SELECT * FROM stage ORDER BY inizio_stage DESC";
                                    
                                $result = $conn->query($query);
                                $I=0;
                                $firstIndex = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $inizio = $row['inizio_stage'];
                                    $inizio = date("d-m-Y", strtotime($inizio));
                                    $fine = $row['fine_stage'];
                                    $id = $row['id_stage'];
                                        
                                    echo "<tr id=\"stage$I\">"
                                            . "<td name='inizio'> "
                                            . "<input onchange=\"\" data-id='$I' id='inizio$I' name='data_inizio' style='text-align: center' class='form-control' value='$inizio' data-provide='datepicker'></td>";
                                    echo "<td> <input onchange=\"\" data-id='$I' id='fine$I' name='data_fine' style='text-align: center' class='form-control' value='$fine' data-provide='datepicker'> </td>";
                                    echo "<td> <button id=\"modifica$I\" type=\"button\" class=\"btn btn-success btn-sm margin buttonfix\" onclick=\"sendData($I, $id)\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>"
                                            . " </td>";
                                                
                                    echo "</tr>";
                                    $I++;
                                }
                            ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col col-sm-2">
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    close_html ("../../../../");
?>