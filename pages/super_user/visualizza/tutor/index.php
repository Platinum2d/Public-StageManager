<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Tutor" );
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
    ?>
    <script src="scripts/scripts.js?0.2"> </script>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Visualizza Tutor</h1> 
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
                        
                                        <?php
                                            
                                            $conn = dbConnection("../../../../");
                                            $query = "SELECT * FROM utente, tutor WHERE id_utente = id_tutor ORDER BY cognome";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            if($result->num_rows > 0)
                                            {
                                                echo "<div class=\"table-responsive\">"
                                                . "<table id=\"tabletutor\" class=\"table table-bordered\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"width:2%; text-align : center\"> <input id=\"checkall\" type=\"checkbox\"> </th> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td><input class=\"singlecheck\" type=\"checkbox\"></td><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo "<div id=\"ButtonBox$I\" align=\"center\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_tutor']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteTutor(".$row['id_tutor'].")\"> <br></div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                echo "</tbody></table></div>";
                                            }
                                            echo "</div>";
                                                
                                            echo "</div>";
                                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>