<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Visualizza Docenti" );
    import("../../../../");
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
        printChat("../../../../");
    ?>
    <script src="scripts/scripts.js"></script>
        
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Visualizza Docenti</h1> <br> 
                                            
                                        <?php
                                            $conn = dbConnection("../../../../");
                                            $query = "SELECT * FROM docente WHERE id_docente != ".$_SESSION['userId']." ORDER BY cognome";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            echo "<div class=\"table-responsive\"><table class=\"table table-bordered\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                                            if($result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<div align=\"center\" id=\"ButtonBox$I\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_docente']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteDocente(".$row['id_docente'].")\"></div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                    
                                            }
                                            echo "</tbody></table></div>";
                                            echo "</div>";
                                                
                                            echo "</div>";
                                            
                                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>