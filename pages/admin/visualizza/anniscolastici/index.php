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
                    <br><br>
                    
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