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
	var inizio_stage = new Date(<?php echo "$anno,$mese,$giorno" ?>);
	var fine_stage = new Date(inizio_stage.getTime() + <?php echo "$durataStage"; ?> * 86400000 );
</script>
<?php
}
?>
<script src="js/script.js"></script>
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
                                            $query_line = $db->query ( "SELECT lavoro_giornaliero.id_lavoro_giornaliero, lavoro_giornaliero.data, lavoro_giornaliero.descrizione 
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
                                                        <th style="width:15%">Data</th>
                                                        <th style="width:65%">Descrizione</th>
                                                        <?php
                                                            if ($autorizzazione === "1") {
                                                                echo " <th>Azioni</th>";
                                                            }
                                                        ?>
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
                                                        <td class="regDesc" id="descrizione<?php echo $I; ?>">
                                                        	<?php echo $work_line['descrizione']; ?>
                                                        </td>
                                                     	<?php
                                                            if ($autorizzazione === "1") {   
                                                        ?>
														<td class="regEdit">
                                                            <div align="center" style="vertical-align: middle">              
                                                                <input type="button" class="btn btn-info" id="modifica<?php echo $I; ?>" name="<?php echo $work_line['id_lavoro_giornaliero']; ?>" value="Modifica" onclick = "openEdit(<?php echo $I; ?>)">
                                                                <input type="button" class="btn btn-danger" id="elimina<?php echo $I; ?>" name="<?php echo $work_line['id_lavoro_giornaliero']; ?>" value="Cancella" onclick = "deleteDescrizione(<?php echo $I; ?>, this.name)">
                                                            </div>
                                                     	<?php
                                                            }   
                                                        ?>
                                                        </td>
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
                                        if ($autorizzazione === "1") {   
                                    ?>                                            
                                    <input type="button" name="<?php echo $I - 1 ?>" id="edit" class="btn btn-success" value="Aggiungi" onclick="appendAddingBox()">
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