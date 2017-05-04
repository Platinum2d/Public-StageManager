<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Valutazione studente" );    
    import("../../../");
    echo "<link href='css/styles-valutazione.css' rel='stylesheet' type='text/css'>";
    $conn = dbConnection ("../../../");
    $idStudenteHasStage = $_POST ['shs'];
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
                    <h1>Valutazione studente</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <?php
                                if (isset($_POST ['shs'])) {
                                    $idStudenteHasStage = $_POST ['shs'];
                                    echo "<script>shs = $idStudenteHasStage;</script>";
                                    echo "<script src='js/scripts-valutazione.js'></script>";
                                    $gia_compilato = true;
                                    
                                    $sql = "SELECT classe_has_stage.modulo_valutazione_studente_id_modulo_valutazione_studente
                                            FROM studente_has_stage, classe_has_stage
                                            WHERE studente_has_stage.id_studente_has_stage = $idStudenteHasStage
                                            AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage;";
                                    $Result = $conn->query ( $sql );
                                    if ($Result && $Result->num_rows > 0) {
                                        $row = $Result->fetch_assoc ();
                                        if (!empty ($row ['modulo_valutazione_studente_id_modulo_valutazione_studente'])) {
                                            $id_modulo = $row ['modulo_valutazione_studente_id_modulo_valutazione_studente'];
                                            $sql_righe = "SELECT id_riga_modulo_studente, numero_voce, descrizione
                                                            FROM riga_modulo_studente
                                                            WHERE modulo_valutazione_studente_id_modulo_valutazione_studente = $id_modulo
                                                            ORDER BY numero_voce;";
                                            $sql_colonne = "SELECT *
                                                            FROM colonna_modulo_studente
                                                            WHERE modulo_valutazione_studente_id_modulo_valutazione_studente = $id_modulo
                                                            ORDER BY numero_voce;";
                                            
                                            $righe_result = $conn->query ( $sql_righe );
                                            if ($righe_result && $righe_result->num_rows > 0) {
                                                $nrig = $righe_result->num_rows;
                                                $rig_tab;
                                                $i = 0;
                                                while ($row = $righe_result->fetch_assoc ()) {
                                                    $rig_tab [$i] ['id'] = $row ['id_riga_modulo_studente'];
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
                                                        $col_tab [$i] ['id'] = $row ['id_colonna_modulo_studente'];
                                                        $col_tab [$i] ['numero_voce'] = $row ['numero_voce'];
                                                        $col_tab [$i] ['descrizione'] = $row ['descrizione'];
                                                        $col_tab [$i] ['risposta_multipla'] = $row ['risposta_multipla'];
                                                        if ($col_tab [$i] ['risposta_multipla']) {
                                                            $sql_risposte = "SELECT id_possibile_risposta_colonna_studente, opzione
                                                                                FROM possibile_risposta_colonna_studente
                                                                                WHERE colonna_modulo_studente_id_colonna_modulo_studente = ".$row ['id_colonna_modulo_studente']."
                                                                                ORDER BY numero_voce;";
                                                            $risposte_result = $conn->query ( $sql_risposte );
                                                            if ($risposte_result && $risposte_result->num_rows > 0) {
                                                                $j = 0;
                                                                while ($subrow = $risposte_result->fetch_assoc ()) {
                                                                	$col_tab [$i] ['risposte'] [$j] ['id'] = $subrow ['id_possibile_risposta_colonna_studente'];
                                                                	$col_tab [$i] ['risposte'] [$j] ['opzione'] = $subrow ['opzione']; 
                                                                    $j++;
                                                                }
                                                            }
                                                        }
                                                        $i++;
                                                    }
                                                    ?>
                            <div class="table-responsive">
                            	<table id="tabellaValutazioneStudente" class="table table-bordered">
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
                                                    	    echo "<td class='col-sm-2'>$testo</td>";
                                                    	    foreach ($col_tab as $col) {
                                                    	        $id_col = $col ['id'];
                                                    	        $sql_risposta = "SELECT risposta
                                                                                    FROM risposta_voce_modulo_studente
                                                                                    WHERE riga_modulo_studente_id_riga_modulo_studente = $id_riga
                                                                                    AND colonna_modulo_studente_id_colonna_modulo_studente = $id_col
                                                                                    AND studente_has_stage_id_studente_has_stage = $idStudenteHasStage;";
                                                    	        $risposta = "";
                                                    	        $risposta_result = $conn->query ( $sql_risposta );
                                                    	        if ($risposta_result && $risposta_result->num_rows > 0) {
                                                    	            $row = $risposta_result->fetch_assoc ();
                                                    	            $risposta = $row ['risposta'];
                                                    	        }
                                                    	        else {
                                                    	        	$gia_compilato = false;
                                                    	        }
                                                    	        if ($col ['risposta_multipla']) {
                                                    	        	echo "<td data-idr='$id_riga' data-idc='$id_col'><select class='form-control answer'>";
                                                    	        	foreach ($col ['risposte'] as $possibile_risposta) {
                                                    	        		$id_opzione = $possibile_risposta ['id'];
                                                    	        		$opzione = $possibile_risposta ['opzione'];
                                                    	        		$selected = "";
                                                    	        		if ($opzione == $risposta) {
                                                    	        			$selected = " selected";
                                                    	        		}
                                                    	        		echo "<option value='$id_opzione'$selected>$opzione</option>";
                                                    	        	}
                                                    	        	echo "</select></td>";
                                                    	        }
                                                    	        else {
                                                    	        	echo "<td data-idr='$id_riga' data-idc='$id_col'><textarea maxlength='800' rows='5' class='form-control answer'>$risposta</textarea></td>";
                                                    	        }
                                                    	    }
                                                    	    echo "</tr>";
                                                    	}
                                                	?>
                                	</tbody>
                            	</table>
                        	</div>
		                    <div class="row">
		                        <div class="col col-sm-12">
							                        <?php
							                        	if ($gia_compilato) {
							                        		echo "<button id='action' onclick='updateAnswers();' class='btn btn-info pull-right'><span class='glyphicon glyphicon-edit'></span> Modifica</button>";
							                        	}
							                        	else {
							                        		echo "<button id='action' onclick='addAnswers();' class='btn btn-success pull-right'><span class='glyphicon glyphicon-save'></span> Salva</button>";
							                        	}
							                        ?>

		                        </div>
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