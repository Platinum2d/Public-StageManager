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
                    <br><br>
                    
                    <table id="annitable" class="table table-bordered">
                        <thead style="background : #eee; font-color : white">
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
                                        echo "<td style=\"text-align : center\"> $nome </td> <td style=\"text-align : center\"> <button id=\"modifica$I\" class=\"btn btn-success\" value=\"Modifica\" onclick=\"openEdit($I, $id)\">Modifica</button>   <button class=\"btn btn-danger\" value=\"Elimina\" onclick=\"deleteSchool($I, $id)\">Elimina</button></td>";
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