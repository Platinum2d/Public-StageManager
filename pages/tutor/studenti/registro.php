<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Registro" );    
    import("../../../");
    $conn = dbConnection ("../../../");
    $id = $_POST ['idstudente']; // id studente
    
    echo "<script src='js/scripts.js'></script>";
    
    $sql = "select `visita_azienda` from `studente` where `id_studente`=$id";
    $Result = $conn->query ( $sql );
    $row = $Result->fetch_assoc ();
    $visita = $row ['visita_azienda'];
    
?>
<body>
	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>STUDENTI</h1>
                    <div class="row">
                        <div class="col col-sm-12">
                            <?php
                                if ($visita == 0) {
                                    
                                    echo <<<HTML
                                    <form method="POST" action="visita_ajax.php">                       
                                    <h3>Lo studente si e presentatato in azienda per un colloquio?</h3>
                                    <div class="row">
                                        <div class="col col-sm-4">
                                        </div>
                                            
                                             <div class="col col-sm-4">
                                            <div id="prima" align="center">
                                               <label style="height:35px; width:35px; vertical-align: middle;"><input style="height:35px; width:35px; vertical-align: middle;" type="radio" name="scelta" value="1"> Si</label>
                                               <label style="height:35px; width:35px; vertical-align: middle;"><input style="height:35px; width:35px; vertical-align: middle;" type="radio" name="scelta" value="0">  No</label> <br>
                                                <input type="hidden" name="id_studente" value=$id>
                                                <input type="hidden" name="page" value="1">
                                            </div>
                                        </div>
                                    </div>    
                                            <input type="submit" name="conferma_scelta" value="conferma" id="conferma_scelta" ><br>
                                        </form>
HTML;
                                }
                                if ($visita >= 1) {
                                    $query_line = $conn->query ( "SELECT * FROM `lavoro_giornaliero`
                                                                    WHERE `lavoro_giornaliero`.`studente_id_studente`=$id 
                                                                    ORDER BY `data` DESC;" );
                            ?>
                            <div id="DescMain">
                                <div class="table-responsive"><table id="DescTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Data</td>
                                            <td>Descrizione delle attivit&agrave; lavorative</td>
                                            <td>Opzioni</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                            			<?php
                                            while ( $work_line = $query_line->fetch_assoc () ) {
                                        ?>
                                        <tr>
                                            <td><?php echo $work_line['data']; ?></td>
                                            <td class="regDesc" style="width: 70%"><?php echo $work_line['descrizione']; ?></td>
                            				<?php
                                                echo "<td class='regOpt'> <div align=\"center\"> <button class='regEdit'>Modifica</button>";
                                                echo "<button class='regDelete'>Elimina</button> </div></td>";
                                                echo "<input type='hidden' class='descId' value='".$work_line['id_lavoro_giornaliero']."' />";
                                            ?>
                                        </tr>
                            			<?php
                                            }
                                        ?>
                                    </tbody>
                                </table></div>
                                <button id="DescAddButton">Aggiungi</button> <br><br>
                                <?php 
                                    $query = "SELECT `AutorizzazioneRegistro` FROM `studente` WHERE `id_studente` = $id";
                                    $result = $conn->query($query);
                                    $row = $result->fetch_assoc();
                                    if ($row['AutorizzazioneRegistro'] === "0")
                                    {
                                        echo "Stanco di compilare il registro? <a href=\"javascript:grantOrRevokeRegisterPermisson('1',$id)\"> Delega lo studente a farlo </a>";
                                    }
                                    else
                                    {
                                        echo "Questo studente e' delegato alla compilazione del registro. Non sei soddisfatto? <a href=\"javascript:grantOrRevokeRegisterPermisson('0',$id)\"> Ritira la delega </a>";
                                    }
                                ?>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>
