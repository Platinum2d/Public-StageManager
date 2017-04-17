<?php
include '../../functions.php';
checkLogin ( docrefType , "../../../");
open_html ( "Gestione studenti" );
import("../../../");
$conn = dbConnection("../../../");
?>
<link href='css/gestione_studenti.css' rel='stylesheet' type='text/css'>
<script src="scripts/script.js?0.1"></script>
<body>
 	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Gestione studenti</h1>
                    <br>                      
                    <!-- <div class="row">
                        <div class="col col-sm-4">
                            <div align="left">
                                <p style="display: inline">Cerca</p> <input style="display: inline" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col col-sm-4">
                            Azione<div align="center">
                                <select class="form-control" id="actions">
                                    <option>  </option>                                    
                                    <option value="1"> Espandi </option>
                                    <option value="2"> Riduci </option>
                                    <option value="3"> Elimina </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col col-sm-4"> 
                            Filtra righe<div align="right">
                                <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php //echo $recordperpagina; ?>">
                            </div>
                        </div>
                    </div>    
                    <br>-->
                    
                    <table id="annitable" class="table table-bordered">
                        <thead>
                        	<tr>
                                <th class="text-center col col-sm-1">Classe</th>
                                <th class="text-center col col-sm-5">Studente</th>
                                <th  class="text-center col col-sm-3">Docente tutor</th>
                                <th  class="text-center col col-sm-3">Azienda</th>
                            </tr>
                        </thead>                        
                        <tbody>
                            <?php
                                $id_docente = $_SESSION ['userId'];
                                $query = "SELECT studente.id_studente, studente_has_stage.id_studente_has_stage, classe.id_classe, classe.nome AS nome_classe, studente.cognome AS cognome_studente, studente.nome AS nome_studente, docente.id_docente, docente.cognome AS cognome_docente, docente.nome AS nome_docente, azienda.id_azienda, azienda.nome_aziendale
                                            FROM studente_has_stage
                                            JOIN docente_referente_has_studente_has_stage ON docente_referente_has_studente_has_stage.studente_has_stage_id_studente_has_stage = studente_has_stage.id_studente_has_stage
                                            JOIN studente ON studente.id_studente = studente_has_stage.studente_id_studente
                                            JOIN classe_has_stage ON classe_has_stage.id_classe_has_stage = studente_has_stage.classe_has_stage_id_classe_has_stage
                                            JOIN anno_scolastico ON anno_scolastico.id_anno_scolastico = classe_has_stage.anno_scolastico_id_anno_scolastico
                                            JOIN classe ON classe.id_classe = classe_has_stage.classe_id_classe
                                            LEFT OUTER JOIN docente ON docente.id_docente = studente_has_stage.docente_tutor_id_docente_tutor
                                            LEFT OUTER JOIN azienda ON azienda.id_azienda = studente_has_stage.azienda_id_azienda
                                            WHERE docente_referente_has_studente_has_stage.docente_id_docente = $id_docente
                                            AND anno_scolastico.corrente = 1
                                            ORDER BY cognome_studente;";
                                $result = $conn->query($query);
                                    
                                $i = 0;
                                while ($result && $row = $result->fetch_assoc())
                                {
                                    $id_studente = $row ['id_studente'];
                                    $id_shs = $row['id_studente_has_stage'];
                                    $id_classe = $row['id_classe'];
                                    $classe = $row ['nome_classe'];
                                    $nome = $row['cognome_studente'] . " " . $row['nome_studente'];
                                    $id_doctutor = $row ['id_docente'];
                                    $docente_tutor = $row['nome_docente'] . " " . $row['cognome_docente'];
                                    $docbutton_class = "btn btn-success";
                                    $id_azienda = $row ['id_azienda'];
                                    $azienda = $row['nome_aziendale'];
                                    $azbutton_class = "btn btn-success";
                                        
                                    echo "<tr data-classe='$id_classe' data-shs='$id_shs'>";
                                        
                                        echo "<td class='text-center'>$classe</td>";
                                        echo "<td class='text-center'><u style='cursor:pointer' onclick=\"userProfile($id_studente, '../../')\">$nome</u></td>";
                                        if ($id_doctutor == "") {
                                            $id_doctutor = -1;
                                            $docente_tutor = "<i>Non assegnato</i>";
                                            $docbutton_class = "btn btn-danger";
                                        }
                                        echo "<td class='text-center'><button class='docTutButton $docbutton_class' data-id='$id_doctutor'>$docente_tutor&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-down'></span></button></td>";
                                        if ($id_azienda == "") {
                                            $id_azienda = -1;
                                            $azienda = "<i>Non assegnata</i>";
                                            $azbutton_class = "btn btn-danger";
                                        }
                                        echo "<td class='text-center'><button class='aziendaButton $azbutton_class' data-id='$id_azienda'>$azienda&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-down'></span></button></td>";
                                    echo "</tr>";
                                        
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    close_html ("../../../");
?>