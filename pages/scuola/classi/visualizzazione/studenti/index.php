<?php
    include '../../../../functions.php';
    checkLogin ( scuolaType , "../../../../../");
    open_html ( "Visualizza Studenti" );
    import("../../../../../");
    $connessione = dbConnection("../../../../../");    
    
    $idclasse = $_POST['id_classe'];
    $idanno = $_POST['years'];
    echo $idclasse . " " . $idanno;
    
    $nomeclasse = $connessione->query("SELECT nome FROM classe WHERE id_classe = $idclasse")->fetch_assoc()["nome"];
    $nomeanno = $connessione->query("SELECT nome_anno FROM anno_scolastico WHERE id_anno_scolastico = $idanno")->fetch_assoc()["nome_anno"];
    $nomescuola = $connessione->query("SELECT s.nome FROM scuola AS s, classe AS c WHERE s.id_scuola = c.scuola_id_scuola AND c.id_classe = $idclasse")->fetch_assoc()["nome"];
?>
<body>
    
    <script>
        localStorage.setItem("clstd", <?php echo $idclasse; ?>);
        localStorage.setItem("anstd", <?php echo $idanno; ?>);
    </script>
    
    <style>
        .minw{
            width: 65%;
        }
    </style>
    
 	<?php
        topNavbar ("../../../../../");
        titleImg ("../../../../../");
    ?>
    <script src="scripts/script.js"> </script>
    <div class="container">
        
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id = "mainPanel">
                    <h1>Studenti della <?php echo $nomeclasse; ?> A.S. <?php echo $nomeanno; ?> <b>(<?php echo $nomescuola;?>)</b></h1>    
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
                                    <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php echo $recordperpagina ?>">
                            </div>
                        </div>
                    </div>    
                    <br>
                    <?php
                        
                        $Query = (isset($idclasse)) ? "SELECT * "
                                                             . "FROM utente AS u, studente AS s, studente_attends_classe AS sac "
                                                             . "WHERE sac.classe_id_classe = $idclasse "
                                                             . "AND sac.anno_scolastico_id_anno_scolastico = $idanno "
                                                             . "AND s.id_studente = sac.studente_id_studente "
                                                             . "AND u.id_utente = sac.studente_id_studente "
                                                             . "ORDER BY cognome "
                                : null;
                                    
                                    
                        if (null !== $Query  && $result = $connessione->query ($Query))
                        {
                            echo "<div class=\"row\">";
                            echo "<div class = \"col col-sm-12\">";
                            $I=0;
                            echo "<div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"tablestudenti\" style=\"\">"
                            . "<thead style=\"background : #eee; font-color : white \"> <th style=\"width:2%; text-align : center\"> <input id=\"checkall\" type=\"checkbox\"> </th> <th style=\"text-align : center\"> Cognome, Nome, Username </th> <th style=\"text-align : center\"> Modifica </th> <th style=\"text-align : center\"> Elimina </th> </thead> <tbody>";
                            while ($row = $result->fetch_assoc ())
                            {
                                echo "<tr><td><input class=\"singlecheck\" type=\"checkbox\"></td><td name=\"".$row['id_studente']."\" class=\"minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";                                
                                    echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td align=\"center\">";
                                    echo "<div id=\"ButtonBox".$I."\" align=\"center\">";
                                         echo "<input class = \"btn btn-success \" name=\"".$row['id_studente']."\"  type=\"button\" value=\"Modifica\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('input').attr('name'), $idclasse, $idanno)\"></td> "
                                                 . "<td align=\"center\"><input class = \"btn btn-danger\" type=\"button\" value=\"Elimina\" id = \"elimina".$I."\" onclick=\"deleteData(".$I.",$('#modifica".$I."').closest('input').attr('name'))\"> </td>";
                                    echo "</div>";
                                echo "</tr>";
                                $I++;
                            }  
                            echo "</tbody></table></div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    close_html ("../../../../../");
?>