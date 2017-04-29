<?php
    include '../../functions.php';
    checkLogin ( studType , "../../../" );
    open_html ( "Valutazione stage" );    
    import("../../../");
    echo "<link href='css/styles.css' rel='stylesheet' type='text/css'>";
    $conn = dbConnection ("../../../");
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
                    <h1>Valutazione stage</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <?php
                                if (isset($_SESSION ['studenteHasStageId'])) {
                                    $idStudenteHasStage = $_SESSION ['studenteHasStageId'];        
                                    echo "<script src='js/scripts.js'></script>";
                                    
                                    $sql = "SELECT classe_has_stage.modulo_valutazione_stage_id_modulo_valutazione_stage
                                    FROM studente_has_stage, classe_has_stage
                                    WHERE studente_has_stage.id_studente_has_stage = $idStudenteHasStage
                                    AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage;";
                                    $Result = $conn->query ( $sql );
                                    if ($Result && $Result->num_rows > 0) {
                                        $row = $Result->fetch_assoc ();
                                        if (!empty ($row ['modulo_valutazione_stage_id_modulo_valutazione_stage'])) {
                                            $id_modulo = $row ['modulo_valutazione_stage_id_modulo_valutazione_stage'];
                                            $sql_righe = "SELECT id_riga_modulo_stage, numero_voce, descrizione
                                                            FROM riga_modulo_stage
                                                            WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $id_modulo
                                                            ORDER BY numero_voce;";
                                            $sql_colonne = "SELECT id_colonna_modulo_stage, numero_voce, descrizione
                                                            FROM colonna_modulo_stage
                                                            WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $id_modulo
                                                            ORDER BY numero_voce;";
                                            
                                            $righe_result = $conn->query ( $sql_righe );
                                            if ($righe_result && $righe_result->num_rows > 0) {
                                                $nrig = $righe_result->num_rows;
                                                $rig_tab;
                                                $i = 0;
                                                while ($row = $righe_result->fetch_assoc ()) {
                                                    $rig_tab [$i] ['id'] = $row ['id_riga_modulo_stage'];
                                                    $rig_tab [$i] ['numero_voce'] = $row ['numero_voce'];
                                                    $rig_tab [$i] ['descrizione'] = $row ['descrizione'];
                                                    $i++;
                                                }
                                                $colonne_result = $conn->query ( $sql_colonne );
                                                if ($colonne_result && $colonne_result->num_rows > 0) {
                                                    $ncol = $colonne_result->num_rows;
                                                    $col_tab;
                                                    $i = 0;
                                                    while ($row = $colonne_result->fetch_assoc ()) {
                                                        $col_tab [$i] ['id'] = $row ['id_colonna_modulo_stage'];
                                                        $col_tab [$i] ['numero_voce'] = $row ['numero_voce'];
                                                        $col_tab [$i] ['descrizione'] = $row ['descrizione'];
                                                        /*if ($col_tab [$i] ['risposta_multipla']) {
                                                            $sql_risposte = "SELECT opzione
                                                                                FROM possibile_risposta_colonna_stage
                                                                                WHERE colonna_modulo_stage_id_colonna_modulo_stage = ".$row ['id_colonna_modulo_stage']."
                                                                                ORDER BY opzione;";
                                                            $risposte_result = $conn->query ( $sql_risposte );
                                                            if ($risposte_result && $risposte_result->num_rows > 0) {
                                                                $j = 0;
                                                                while ($subrow = $risposte_result->fetch_assoc ()) {
                                                                    $col_tab [$i] ['risposte'] [$j] = $subrow ['opzione'];
                                                                    $j++;
                                                                }
                                                            }
                                                        }*/
                                                        $i++;
                                                    }
                                                    ?>
                            <div class="table-responsive">
                            	<table id="tabellaValutazioneStage" class="table table-bordered">
                                    <thead>
                                        <tr>
                                        	<td></td>
                                                    <?php
                                                        foreach ($col_tab as $col) {
                                                            $testo = $col ['descrizione'];
                                                            echo "<th class='text-center'>$testo</th>";
                                                        }
                                                    ?>
                                    	</tr>
                                	</thead>
                                	<tbody>
                                                	<?php
                                                    	foreach ($rig_tab as $rig) {
                                                    	    $testo = $rig ['descrizione'];
                                                    	    $id_riga = $rig ['id'];
                                                    	    echo "<tr>";
                                                    	    echo "<td>$testo</td>";
                                                    	    foreach ($col_tab as $col) {
                                                    	        $id_col = $col ['id'];                                                    	        
                                                    	        $sql_risposta = "SELECT risposta
                                                                                    FROM risposta_voce_modulo_stage
                                                                                    WHERE riga_modulo_stage_id_riga_modulo_stage = $id_riga
                                                                                    AND colonna_modulo_stage_id_colonna_modulo_stage = $id_col
                                                                                    AND studente_has_stage_id_studente_has_stage = $idStudenteHasStage;";
                                                    	        $risposta_result = $conn->query ( $sql_risposta );
                                                    	        if ($risposta_result && $risposta_result->num_rows > 0) {
                                                    	            $row = $risposta_result->fetch_assoc ();
                                                    	            $risposta = $row ['risposta'];
                                                    	            echo "<td>$risposta</td>";
                                                    	        }
                                                    	    }
                                                    	    echo "</tr>";
                                                    	}
                                                	?>
                                	</tbody>
                            	</table>
                        	</div>
                                                    <?php
                                                }
                                                else {
                                                    printProblemContent();
                                                }
                                            }
                                            else {
                                                printProblemContent();
                                            }
                                        }
                                        else {
                                            ?>
                            <div class="text-center">
                                <h4 class="bg-warning studentNoModelWarning">
            						Pagina al momento non disponibile.
            						<br>
            						Non appena il responsabile scolastico si sarà occupato del tuo modulo, avrai accesso a questa funzionalità.
            					</h4>
                            </div>
                                            <?php
                                        }
                                    }
                                }
                                else {
                                    studentNoStageWarning();
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