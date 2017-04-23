<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Visualizza Studenti" );
    import("../../../../");
    $connessione = dbConnection("../../../../");    
        
    $idclasse = $_POST['id_classe'];
    $idanno = $_POST['years'];    
        
    $nomeclasse = $connessione->query("SELECT nome FROM classe WHERE id_classe = $idclasse")->fetch_assoc()["nome"];
    $nomeanno = $connessione->query("SELECT nome_anno FROM anno_scolastico WHERE id_anno_scolastico = $idanno")->fetch_assoc()["nome_anno"];
    $nomescuola = $connessione->query("SELECT s.nome FROM scuola AS s, classe AS c WHERE s.id_scuola = c.scuola_id_scuola AND c.id_classe = $idclasse")->fetch_assoc()["nome"];
?>
<body>
    
    <script>
        localStorage.setItem("nome_classe", "<?php echo $nomeclasse; ?>");
        localStorage.setItem("nome_anno", "<?php echo $nomeanno; ?>");
    </script>
    
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
    <script src="scripts/script.js?2"> </script>
    <div class="container">
        
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id = "mainPanel">
                    <h1>Studenti della <?php echo $nomeclasse; ?></h1>
                    <br>
                    <div align='right'>
                        <a href='javascript:askForDeleteClass(<?= $idclasse; ?>, <?= $idanno; ?>)'><u>Desidero eliminare questa classe</u></a>
                    </div>
                    <br>
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
                                echo "<tr><td><input class=\"singlecheck\" type=\"checkbox\"></td><td name=\"".$row['id_studente']."\" class=\"iwrap minw\">";
                                echo "<div id=\"VisibleBox".$I."\">";                                
                                    echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label><input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                echo "</div>";
                                echo "</td>";
                                echo "<td align=\"center\">";
                                    echo "<div id=\"ButtonBox".$I."\" align=\"center\">";
                                         echo "<button class = \"btn btn-success \" name=\"".$row['id_studente']."\" id = \"modifica".$I."\" onclick = \"openEdit('VisibleBox".$I."',$(this).closest('button').attr('name'), $idclasse, $idanno)\"><span class='glyphicon glyphicon-edit'></span> Modifica</button></td> "
                                                 . "<td align=\"center\"><button class = \"btn btn-danger\" value=\"\" id = \"elimina".$I."\" onclick=\"askForDeleteStudent(".$I.", ".$row['id_studente'].", $idclasse, $idanno)\"><span class='glyphicon glyphicon-trash'></span> Elimina</button> </td>";
                                    echo "</div>";
                                echo "</tr>";
                                $I++;
                            }  
                            echo "</tbody></table></div>";
                        }
                    ?>
                    <br>
                    <div class="col col-sm-4">
                        
                    </div>
                    <div class="col col-sm-8" align='right'>
                        <h3 style='display: inline'>A.S. <?php echo $nomeanno; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="row">
                <div class="col col-sm-12">
                    <div class="row">
                        <div class="col col-sm-6">                            
                            <form enctype="multipart/form-data" method="POST" action="studentloader.php" name="uploadform">
                                Seleziona il file contenente gli studenti da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="studentfile">
                                <input type="hidden" name="classe" value="<?php echo $idclasse; ?>">
                                <input type="hidden" name="anno" value="<?php echo $idanno; ?>">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                <div align="right">
                                    <u><a style="color: #828282" href="Stage_Manager_Modulo_Studenti.xlsx" download>Scarica modello per gli studenti</a></u>
                                </div>
                            </form>
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