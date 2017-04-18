<?php
    include '../../../functions.php';
    checkLogin ( ceoType , "../../../../");
    open_html ( "Visualizza Tutor" );
    import("../../../../");
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
    <script src="scripts/scripts.js?1"> </script>
        
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id="mainPanel" style="min-height: 0px">
                    <h1>Visualizza Tutor</h1> 
                    <?php
                        $conn = dbConnection("../../../../");
                        $query = "SELECT * FROM utente, tutor WHERE id_utente = id_tutor AND azienda_id_azienda = ".$_SESSION['userId'];
                        $result = $conn->query($query);
                        echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                        $I=0;
                        if($result->num_rows > 0)
                        {
                            echo "<br><div class=\"table-responsive\"><table id=\"tabletutor\" class=\"table table-bordered\"> <thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                            while ($row = $result->fetch_assoc())
                            {
                                echo "<tr id='riga$I'><td class=\"minw\">";
                                echo "<div id=\"VisibleBox$I\">";
                                    echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<div id=\"ButtonBox$I\" align=\"center\">"
                                            . "<button class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" onclick=\"openEdit('$I','".$row['id_tutor']."')\"><span class='glyphicon glyphicon-edit'></span> Modifica</button> "
                                            . "<button class=\"btn btn-danger\" type=\"button\" onclick = \"askForDeleteTutor(".$row['id_tutor'].", $I)\"><span class='glyphicon glyphicon-trash'></span> Elimina</button> <br></div>";
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