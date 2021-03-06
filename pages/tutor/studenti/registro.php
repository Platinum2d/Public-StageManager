<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Registro" );    
    import("../../../");
    $conn = dbConnection ("../../../");
    $idStudenteHasStage = $_POST ['shs'];
    
    echo "<script src='js/scripts_registro.js?0.4'></script>";
    
    $sql = "SELECT studente_has_stage.visita_azienda, stage.inizio_stage, stage.fine_stage  
			FROM studente_has_stage, stage, classe_has_stage 
			WHERE studente_has_stage.id_studente_has_stage = $idStudenteHasStage 
			AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage 
			AND classe_has_stage.stage_id_stage = stage.id_stage;";
    $Result = $conn->query ( $sql );
    $row = $Result->fetch_assoc ();
    $visita = $row ['visita_azienda'];
    $inizioStage = explode ("-", $row ['inizio_stage']);
    $fineStage = explode ("-", $row ['fine_stage']);
    $anno_inizio = $inizioStage[0];
    $mese_inizio = $inizioStage[1] - 1;
    $giorno_inizio = $inizioStage[2];
    $anno_fine = $fineStage[0];
    $mese_fine = $fineStage[1] - 1;
    $giorno_fine = $fineStage[2];
?>
<script>
	var shs = <?php echo $_POST['shs'] ?>;
	var inizio_stage = new Date(<?php echo "$anno_inizio,$mese_inizio,$giorno_inizio"; ?>);
	var fine_stage = new Date(<?php echo "$anno_fine,$mese_fine,$giorno_fine"; ?>);
</script>
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
                                <div class="table-responsive"><table id="DescTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-center col col-sm-2">Data</td>
                                            <td class="text-center col col-sm-3">Attività svolte</td>
                                            <td class="text-center col col-sm-3">Capacità acquisite</td>
                                            <td class="text-center col col-sm-2">Commenti</td>
                                            <td class="text-center col col-sm-2">Opzioni</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                            			<?php
                                            while ( $work_line = $query_line->fetch_assoc () ) {
                                                if (isset($work_line['commento'])) {
                                                        $commento = $work_line['commento'];
                                                }
                                                else {
                                                        $commento = "";
                                                }
                                        ?>
                                        <tr>
                                            <td class="regDate"><?php echo date("d-m-Y", strtotime($work_line['data'])); ?></td>
                                            <td class="regLavoro"><?php echo $work_line['lavoro_svolto']; ?></td>
                                            <td class="regInsegnamenti"><?php echo $work_line['insegnamenti']; ?></td>
                                            <td class="regCommento"><?php echo $commento ?></td>
                            				<?php
                                                echo "<td class='regOpt pull-content-bottom text-center'><button class='regEdit btn btn-warning buttonfix btn-sm margin'><span class='glyphicon glyphicon-edit'></span></button> ";
                                                echo "<button class='regDelete btn btn-danger buttonfix btn-sm margin'><span class='glyphicon glyphicon-trash'></span></button></td>";
                                                echo "<input type='hidden' class='descId' value='".$work_line['id_lavoro_giornaliero']."' />";
                                            ?>
                                        </tr>
                            			<?php
                                            }
                                        ?>
                                    </tbody>
                                </table></div>
                                <button id="DescAddButton" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Aggiungi</button>
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
