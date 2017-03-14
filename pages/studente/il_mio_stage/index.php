<?php
    include '../../functions.php';
    checkLogin ( studType , "../../../");
    open_html ( "Il mio stage" );
    import("../../../");
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
                    <h1>Il mio stage</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <?php
                                
                                function sommaGiorni($dateadd, $duratas) {
                                    list ( $giorno, $mese, $anno ) = explode ( '-', $dateadd );
                                    return date ( "d-m-Y", mktime ( 0, 0, 0, $mese, $giorno + $duratas, $anno ) );
                                }
                                    
                                $idstud = $_SESSION ['userId'];
                                if (isset($_SESSION ['studenteHasStageId']))
                                {
                                    $idStudtudenteHasStage = $_SESSION ['studenteHasStageId'];
                                    $conn = dbConnection("../../../");
                                        
                                    $idazst = $conn->query ("SELECT `azienda_id_azienda` 
                                                            FROM `studente_has_stage` 
                                                            WHERE id_studente_has_stage = $idStudtudenteHasStage;");
                                    $idazst = $idazst->fetch_assoc ();
                                    $idazst = $idazst ["azienda_id_azienda"];
                                        
                                    // output dell'azienda a cui si è assegnati
                                    if (isset ( $idazst )) {
                                        $output = $conn->query ( "SELECT `nome_aziendale`, `citta_aziendale`, `CAP`, `indirizzo`, `telefono_aziendale`, `email_aziendale`, `sito_web`, `nome_responsabile`, `cognome_responsabile`, `telefono_responsabile`, `email_responsabile`, `id_azienda` FROM `azienda` WHERE id_azienda = $idazst;" );
                                        $azienda = $output->fetch_assoc();
                                            
                                        $nome = $azienda ['nome_aziendale'];
                                        $citta = $azienda ['citta_aziendale'];
                                        $cap = $azienda ['CAP'];
                                        $indirizzo = $azienda ['indirizzo'];
                                        $telefono = (isset($azienda ['telefono_aziendale'])) ? $azienda ['telefono_aziendale'] : '';
                                        $sito = (isset($azienda ['sito_web'])) ? $azienda ['sito_web'] : '';
                                        $nome_responsabile = (isset($azienda ['nome_responsabile'])) ? $azienda ['nome_responsabile'] : '';
                                        $cognome_responsabile = (isset($azienda ['cognome_responsabile'])) ? $azienda ['cognome_responsabile'] : '';
                                        $telefono_responsabile = (isset($azienda ['telefono_responsabile'])) ? $azienda ['telefono_responsabile'] : '';
                                        $email_responsabile = (isset($azienda ['email_responsabile'])) ? $azienda ['email_responsabile'] : ''; 
                                        $email = (isset($azienda['email_aziendale'])) ? $azienda['email_aziendale'] : '';
                                        // output del tutor a cui si è assegnati
                                        $idtust = $conn->query ("SELECT `tutor_id_tutor` 
                                                                FROM `studente_has_stage` 
                                                                WHERE id_studente_has_stage = $idStudtudenteHasStage;");
                                        if ($idtust->num_rows > 0)
                                        {
                                            $idtust = $idtust->fetch_assoc ();
                                            $idtust = $idtust ["tutor_id_tutor"];
                                        }
                                        else 
                                        {
                                            $idtust = null;
                                        }
                                            
                                        if ($idtust !== null)
                                        {
                                            $outputut = $conn->query ( "SELECT `nome`, `cognome`, `id_tutor` 
                                                                        FROM `tutor` 
                                                                        WHERE id_tutor=$idtust" );
                                            if ($outputut->num_rows > 0)
                                            {
                                                $tutor = $outputut->fetch_assoc ();
                                                    
                                                $cognome_tutor_az = $tutor ['cognome'];
                                                $nome_tutor_az = $tutor ['nome'];
                                            }
                                        }
                                        else
                                        {
                                            $cognome_tutor_az = null;
                                            $nome_tutor_az = "<u><i>Non assegnato</i></u>";
                                        }
                                        //tutor scolastico
                                        $iddost = $conn->query ("SELECT `docente_tutor_id_docente_tutor` 
                                                                FROM `studente_has_stage` 
                                                                WHERE id_studente_has_stage = $idStudtudenteHasStage;");
                                        if ($iddost->num_rows > 0)
                                        {
                                            $iddost = $iddost->fetch_assoc ();
                                            $iddost = $iddost ["docente_tutor_id_docente_tutor"];
                                        }
                                        else 
                                        {
                                            $iddost = null;
                                        }
                                            
                                        if ($iddost !== null)
                                        {
                                            $outputdo = $conn->query ( "SELECT `nome`, `cognome`, `id_docente` 
                                                                        FROM `docente` 
                                                                        WHERE id_docente=$iddost" );
                                            if ($outputdo->num_rows > 0)
                                            {
                                                $docente = $outputdo->fetch_assoc ();
                                                $cognome_tutor_sc = $docente ['cognome'];
                                                $nome_tutor_sc = $docente ['nome'];
                                            }
                                        }
                                        else
                                        {
                                            $cognome_tutor_sc = null;
                                            $nome_tutor_sc = "<u><i>Non assegnato</i></u>";
                                        }
                                        // ouput periodo stage
                                        $query_stage = "SELECT stage.inizio_stage, stage.durata_stage 
                                                        FROM studente_has_stage, classe_has_stage, stage 
                                                        WHERE studente_has_stage.id_studente_has_stage = $idStudtudenteHasStage 
                                                        AND studente_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage 
                                                        AND classe_has_stage.stage_id_stage = stage.id_stage;";
                                        $result = $conn->query ($query_stage);
                                            
                                        $inizio_stage = "SCONOSCIUTO";
                                        $fine_stage = "SCONOSCIUTO";
                                        $row = $result->fetch_assoc ();
                                        if (isset ($row ['durata_stage'])){
                                            $duratas = $row ['durata_stage'];
                                        }
                                        if (isset ($row ['inizio_stage'])){
                                            $inizio_stage = date("d-m-Y", strtotime($row ['inizio_stage']));
                                        }
                                        if (isset ($row ['inizio_stage']) && isset ($row ['durata_stage'])){
                                            $fine_stage = sommaGiorni ( $inizio_stage, $duratas );
                                        }
                                        echo <<<HTML
                                            <p>
                                                Ecco le informazioni relative all'azienda alla quale sei stato assegnato:
                                            </p>
                                            <br>
                                            <div class=\"table-responsive\"><table id="myStage" class="table table-striped">
                                                <tr>
                                                    <th class="col-sm-5">Nome azienda</th>
                                                    <td class="col-sm-5">$nome</td>
                                                </tr>
                                                <tr>
                                                    <th>Citt&agrave; azienda</th>
                                                    <td>$citta</td>
                                                </tr>
                                                <tr>
                                                    <th>CAP</th>
                                                    <td>$cap</td>
                                                </tr>
                                                <tr>
                                                    <th>Indirizzo</th>
                                                    <td>$indirizzo</td>
                                                </tr>
                                                <tr>
                                                    <th>Telefono</th>
                                                    <td>$telefono</td>
                                                </tr>
                                                <tr>
                                                    <th>E-mail</th>
                                                    <td>$email</td>
                                                </tr>
                                                <tr>
                                                    <th>Sito web</th>
                                                    <td><a href="http://$sito" target="_blank">$sito</a></td>
                                                </tr>
                                                <tr>
                                                    <th>Nome responsabile</th>
                                                    <td>$nome_responsabile</td>
                                                </tr>
                                                <tr>
                                                    <th>Cognome responsabile</th>
                                                    <td>$cognome_responsabile</td>
                                                </tr>
                                                <tr>
                                                    <th>Telefono resposnabile</th>
                                                    <td>$telefono_responsabile</td>
                                                </tr>
                                                <tr>
                                                    <th>E-mail responsabile</th>
                                                    <td>$email_responsabile</td>
                                                </tr>
                                                <tr>
                                                    <th>Tutor aziendale</th>
                                                    <td>$nome_tutor_az $cognome_tutor_az</td>
                                                </tr>
                                                <tr>
                                                    <th>Tutor scolastico</th>
                                                    <td>$nome_tutor_sc $cognome_tutor_sc</td>
                                                </tr>
                                                <tr>
                                                    <th>Inizio stage</th>
                                                    <td>$inizio_stage</td>
                                                </tr>
                                                <tr>
                                                    <th>Fine stage</th>
                                                    <td>$fine_stage</td>
                                                </tr>
                                            </table></div>
HTML;
                                    }
                                    else {
                                        echo <<<HTML
                                        <div align="center">
                                            <h1 class="alert-warning"> Non sei assegnato a nessuna azienda. </h1>
                                        </div>
HTML;
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