<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Visualizza Docenti" );
    import("../../../../");
    /*$recordperpagina = (isset($_POST['customdocente'])) ? $_POST['customdocente'] : null;
    if (!isset($recordperpagina)){  
        $recordperpagina = (!isset($_POST['ndocenti'])) ? 10 : $_POST['ndocenti'];
    }
    if ($recordperpagina <= 0) $recordperpagina = 1;*/
?>
<body>
    <style>
        .minw{
            width: 65%;
        }
        .custlabel{
            margin-bottom: 0px;
            margin-top: 5px;
        }
    </style>    
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <script src="scripts/scripts.js?1"></script>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Modifica Docenti</h1>   
                    <br>
                                        <?php 
                                            $conn = dbConnection("../../../../");
                                            $query = "SELECT * FROM utente, docente WHERE id_docente = id_utente AND docente.scuola_id_scuola = ".$_SESSION['userId']." ORDER BY cognome";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            echo "<div class=\"table-responsive\"><table id=\"tabledocenti\" class=\"table table-bordered\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"width:2%; text-align : center\"> <input id=\"checkall\" type=\"checkbox\"> </th> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                                            if(is_object($result) && $result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td><input class=\"singlecheck\" type=\"checkbox\"></td><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<div align=\"center\" id=\"ButtonBox$I\"><button class=\"btn btn-success\" id=\"modifica$I\" onclick=\"openEdit('$I','".$row['id_docente']."')\"><span class='glyphicon glyphicon-edit'></span> Modifica</button> "
                                                            . "<button class=\"btn btn-danger\" onclick = \"deleteDocente(".$row['id_docente'].")\"><span class='glyphicon glyphicon-trash'></span> Elimina</button></div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                    
                                            }
                                            echo "</tbody></table></div>";
                                                
                                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>