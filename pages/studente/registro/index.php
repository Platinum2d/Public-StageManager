<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    open_html ( "Registro stage" );
    import("../../../");
    
    $db = dbConnection("../../../");
    if (isset($_SESSION ['studenteHasStageId'])) {
    	$idStudtudenteHasStage = $_SESSION ['studenteHasStageId'];
    	$query_stage = "SELECT stage.inizio_stage, stage.durata_stage
    	FROM studente_has_stage, stage, classe_has_stage
    	WHERE studente_has_stage.id_studente_has_stage = $idStudtudenteHasStage
    	AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
    	AND classe_has_stage.stage_id_stage = stage.id_stage;";
    	$resultStage = $db->query ( $query_stage );
    	$rowStage = $resultStage->fetch_assoc ();
    	$inizioStage = explode ("-", $rowStage ['inizio_stage']);
    	$durataStage = $rowStage ['durata_stage'] - 1;
    	$anno = $inizioStage[0];
    	$mese = $inizioStage[1] - 1;
    	$giorno = $inizioStage[2];
    	?>
    <script>
    	var inizio_stage = new Date(<?php echo "$anno,$mese,$giorno"; ?>);
    	var fine_stage = new Date(inizio_stage.getTime() + <?php echo "$durataStage"; ?> * 86400000 );
    </script>
<?php
    }
?>
<script src="js/script.js?0.3"></script>
<body>
   	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Registro stage</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                                    <?php
                                        if (isset($_SESSION ['studenteHasStageId'])) {                           
                                            $query_line = $db->query ( "SELECT lavoro_giornaliero.id_lavoro_giornaliero, lavoro_giornaliero.data, lavoro_giornaliero.lavoro_svolto, lavoro_giornaliero.insegnamenti, lavoro_giornaliero.commento 
        																FROM lavoro_giornaliero 
        																WHERE lavoro_giornaliero.studente_has_stage_id_studente_has_stage = $idStudtudenteHasStage 
        																ORDER BY data ASC;");
                                                
                                            $Query = "SELECT autorizzazione_registro 
                                                        FROM studente_has_stage 
                                                        WHERE id_studente_has_stage = $idStudtudenteHasStage;";
                                            $result = $db->query($Query);
                                            $row = $result->fetch_assoc();
                                            $autorizzazione = $row['autorizzazione_registro'];
                                    ?>
                                        <input type="hidden" id="contatoreaggiungi" value="0">                                        
                                        <div id="DescMain">
                                            <div class="table-responsive"><table id="DescTable" class="table table-bordered" style="table-layout: fixed">
                                                <thead>
                                                    <tr>
                                                        <th class="col col-sm-2 text-center">Data</th>
                                                        <th class="col col-sm-3 text-center">Attività svolte</th>
                                                        <th class="col col-sm-3 text-center">Capacità acquisite</th>
                                                        <th class="col col-sm-2 text-center">Commento</th>
                                                        <th class='col col-sm-2 text-center'>Azioni</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $I=0;
                                                        while ($work_line = $query_line->fetch_assoc ()) {
                                                    ?>
                                                    <tr id="riga<?php echo $I; ?>">
                                                        <td id="data<?php echo $I; ?>">
                                                    		<?php echo date("d-m-Y", strtotime($work_line['data'])); ?>
                                                        </td >
                                                        <td class="regLavoro" id="lavoroSvolto<?php echo $I; ?>">
                                                        	<?php echo $work_line['lavoro_svolto']; ?>
                                                        </td>
														<td class="regIns" id="insegnamenti<?php echo $I; ?>">
                                                        	<?php echo $work_line['insegnamenti']; ?>
                                                        </td>
														<td class="regComm" id="commento<?php echo $I; ?>">
															<?php
																if (isset ($work_line['commento'])) {
																	echo $work_line['commento'];
																}
															?>
                                                        </td>
                                                     	<?php
                                                            if ($autorizzazione == "1") {   
                                                        ?>
														<td class="regEdit pull-content-bottom">
                                                            <div align="center" style="vertical-align: middle;">              
                                                                <button class="btn btn-warning buttonfix btn-sm margin" id="modifica<?php echo $I; ?>" onclick = "openEdit(<?php echo $I; ?>, <?php echo $work_line['id_lavoro_giornaliero']; ?>)"><span class="glyphicon glyphicon-edit"></span></button>
                                                                <button class="btn btn-danger buttonfix btn-sm margin" id="elimina<?php echo $I; ?>" onclick = "deleteDescrizione(<?php echo $I; ?>, <?php echo $work_line['id_lavoro_giornaliero']; ?>)"><span class="glyphicon glyphicon-trash"></span></button>
                                                            </div>
                                                        </td>
                                                     	<?php
                                                            }   
                                                        ?>
                                                    </tr>
                                                    <?php
                                                            $I++;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                        if ($autorizzazione == "1") {   
                                    ?>                                            
                                    <button name="<?php echo $I - 1 ?>" id="edit" class="btn btn-info" onclick="appendAddingBox()"><span class="glyphicon glyphicon-plus"></span> Aggiungi</button>
                                    <?php
                                        } 
                                    }
                                    else {
                                        studentNoStageWarning ();
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
    close_html ("../../../");
?>