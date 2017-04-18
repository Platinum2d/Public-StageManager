<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    open_html ( "Voto" );
    import("../../../");
    echo "<link href='css/style.css' rel='stylesheet' type='text/css'>";
?>
<script type="text/javascript" src="js/script.js"></script>
<body>
	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
        
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Voto azienda</h1>            
                        <br>
                        <div class="row">
                        <?php
                            if (isset($_SESSION ['studenteHasStageId'])) {
                                $idStudenteHasStage = $_SESSION ['studenteHasStageId'];
                                $connection = dbConnection("../../../");
                                $Query = "SELECT studente_has_stage.azienda_id_azienda  
                        					FROM studente_has_stage 
                        					WHERE studente_has_stage.id_studente_has_stage = $idStudenteHasStage 
                        					AND studente_has_stage.azienda_id_azienda IS NOT NULL";
                                $result = $connection->query($Query);
                                    
                                if ($result->num_rows > 0)
                                {
									$row = $result->fetch_assoc();
                                    $Query = "SELECT valutazione_stage.voto, valutazione_stage.descrizione 
                        						FROM studente_has_stage, valutazione_stage 
                        						WHERE studente_has_stage.id_studente_has_stage =  $idStudenteHasStage 
                        						AND valutazione_stage.id_valutazione_stage = studente_has_stage.valutazione_stage_id_valutazione_stage;";
                                    $result = $connection->query($Query);
                                    if ($result->num_rows <= 0)
                                    {
                            ?>
                            <div class="col col-sm-8">
                                <h2>Dai un voto alla tua azienda:</h2>
                                <div id="voto">
                                        <div>
                                            <select style = "width : 80px" name="voto" id="selectVoto" class="form-control">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                        <h2>Dai una descrizione del tuo lavoro svolto:</h2>                     
                                        <textarea rows ="10" cols="70" name="descrizione" id="styled" class="form-control"></textarea>
                                        <br>
                                        <button class="btn btn-info" onclick="sendGrade()"><span class="glyphicon glyphicon-save"></span> Invia</button>
                                </div>                           
                            </div>
                        </div>
                            <?php
                                    }
                                    else
                                    {
                                    	$row = $result->fetch_assoc();
                                        $voto = $row['voto'];
                                        $descrizione = $row['descrizione'];
                            
                                       echo "<div class=\"col col-sm-8\">
                                            <h2>Modifica il voto precedentemente rilasciato: </h2>
                                            <div id=\"voto\">
                                                <div class=\"\">
                                                <input type=\"hidden\" id=\"hiddenVoto\" value=\"$voto\">
                                                    <select style=\"width: 80px\" name=\"voto\" id=\"selectVoto\" class=\"form-control\">
                                                        <option value=\"1\">1</option>
                                                        <option value=\"2\">2</option>
                                                        <option value=\"3\">3</option>
                                                        <option value=\"4\">4</option>
                                                        <option value=\"5\">5</option>
                                                        <option value=\"6\">6</option>
                                                        <option value=\"7\">7</option>
                                                        <option value=\"8\">8</option>
                                                        <option value=\"9\">9</option>
                                                        <option value=\"10\">10</option>
                                                    </select>
                                                </div>
                                                <h2>Modifica la descrizione precedentemente fornita:</h2>                     
                                                <textarea rows =\"10\" style = \"height:40%\" cols=\"70\" name=\"descrizione\" id=\"styled\" class=\"form-control\">$descrizione</textarea>
                                                <br>";
                                            echo "<button class=\"btn btn-info\" onclick=\"sendGrade()\"><span class=\"glyphicon glyphicon-save\"></span> Invia</button>";
                                            echo "</div>
                                        </div>
                                    </div> ";                       
                            ?>
                            <script type="text/javascript">
                                var voto = parseInt($('#hiddenVoto').val());
                                $("#selectVoto").prop('selectedIndex', voto - 1);                        
                            </script>                    
                            <?php            
                                    } 
                                }
                                else
                                {
                            ?>
                  		<div class="col col-sm-12">
                            <div class="text-center">
			                    <h4 class="bg-warning studentNoStageWarning">
									Pagina al momento non disponibile.
									<br>
									Non appena il tuo docente referente ti avrà assegnato ad un'azienda, avrai accesso a questa funzionalità.
								</h4>
			                </div>
			            </div>
                    <?php
                            }
                        }
                        else {
                        	echo "<div class='col col-sm-12'>";
                            studentNoStageWarning();
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html("../../../");
?>