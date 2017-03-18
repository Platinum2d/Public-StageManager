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
        
    <script src="scripts/script.js"></script>
        
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
                                <th style="text-align : center; width: 25%"> Inizio </th>
                                <th style="text-align : center; width: 10%"> Durata </th>
                                <th style="text-align : center; width: 25%"> Azioni </th>
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
                                    $durata = $row['durata_stage'];
                                    $id = $row['id_stage'];
                                        
                                    echo "<tr id=\"stage$I\">"
                                            . "<td name='inizio'> "
                                            . "<input onchange=\"$(this).css('color', 'red')\" name='datawrapper' style='text-align: center' class='form-control' value='$inizio' data-provide='datepicker'></td>";
                                    echo "<td contenteditable=\"true\" oninput=\"$(this).css('color', 'red')\" name='durata'>$durata</td>";
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
    <script>
        $("input[name='datawrapper']").each(function (){
            $(this).datepicker({dateFormat : 'dd-mm-yy'});
        });
    </script>
</body>
    
<?php
    close_html ("../../../../");
?>