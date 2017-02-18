<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Registro" );    
    import("../../../");
    $conn = dbConnection ("../../../");
    $idStudenteHasStage = $_POST ['shs'];
    
    echo "<script src='js/scripts_registro.js'></script>";
    
    $sql = "select `visita_azienda` from `studente_has_stage` where `id_studente_has_stage`=$idStudenteHasStage";
    $Result = $conn->query ( $sql );
    $row = $Result->fetch_assoc ();
    $visita = $row ['visita_azienda'];
    
?>
<script>var shs = <?php echo $_POST['shs'] ?>;</script>
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
                    <h1>Studenti</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <?php
                                if ($visita == 0) {
                            ?>
                                <script>window.location.replace("index.php");</script>
                            <?php 
                                }
                                if ($visita >= 1) {
                                    $query_line = $conn->query ( "SELECT * 
                                    								FROM `lavoro_giornaliero` 
                                                                    WHERE `lavoro_giornaliero`.`studente_has_stage_id_studente_has_stage` = $idStudenteHasStage  
                                                                    ORDER BY `data` ASC;" );
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
                                            <td class="regDate"><?php echo $work_line['data']; ?></td>
                                            <td class="regDesc"><?php echo $work_line['descrizione']; ?></td>
                            				<?php
                                                echo "<td class='regOpt'><button class='regEdit btn btn-primary'>Modifica</button> ";
                                                echo "<button class='regDelete btn btn-primary'>Elimina</button></td>";
                                                echo "<input type='hidden' class='descId' value='".$work_line['id_lavoro_giornaliero']."' />";
                                            ?>
                                        </tr>
                            			<?php
                                            }
                                        ?>
                                    </tbody>
                                </table></div>
                                <button id="DescAddButton" class="btn btn-primary">Aggiungi</button>
                            </div>
                            <div style="margin-top: 20px;">
                                <?php 
                                    $query = "SELECT `autorizzazione_registro` FROM `studente_has_stage` WHERE `id_studente_has_stage` = $idStudenteHasStage;";
                                    $result = $conn->query($query);
                                    $row = $result->fetch_assoc();
                                    if ($row['autorizzazione_registro'] === "0")
                                    {
                                        echo "Stanco di compilare il registro? <a href=\"javascript:grantOrRevokeRegisterPermisson('1',$idStudenteHasStage)\"> Delega lo studente a farlo </a>";
                                    }
                                    else
                                    {
                                        echo "Questo studente e' delegato alla compilazione del registro. Non sei soddisfatto? <a href=\"javascript:grantOrRevokeRegisterPermisson('0',$idStudenteHasStage)\"> Ritira la delega </a>";
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>
