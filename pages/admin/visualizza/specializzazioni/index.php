<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Visualizza Specializzazioni" );
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
    
    <script src="scripts/script.js"> </script>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" style="min-height: 0px">
                    <h1>Visualizza Specializzazioni</h1>    
                    <br>
                    <?php
                        $connessione = dbConnection("../../../../");
                        $Query = "SELECT * FROM specializzazione";
                        if ($result = $connessione->query ($Query))
                        {
                            echo "<div class=\"row\"> <div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table class=\"table table-bordered\"><thead style=\"background : #eee; font-color : white \"> <th style=\"text-align : center\"> Nome della specializzazione </th> <th style=\"text-align : center\"> Azioni </th></thead>  <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";
                                    echo "<label id=\"label".$I."\"> ".$row['nome']."     </label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                
                                echo "<td>";
                                     echo "<div align=\"center\" id=\"ButtonBox$I\"> <input class = \"btn btn-success\" name=\"".$row['id_specializzazione']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'))\"> <input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData($('#modifica".$I."').closest('input').attr('name'))\"> </div>";
                                echo "</td>";
                                $I++;
                            }
                            
                            echo "</tbody></table></div>";
                            echo "</div>";
                            echo "</div>";
                        }     
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
    
<?php
    close_html ();
?>