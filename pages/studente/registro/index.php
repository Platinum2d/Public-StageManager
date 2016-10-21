<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    open_html ( "Registro stage" );
    import("../../../");
?>
<body>
   	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <script src="script.js"> </script>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Registro stage</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                                    <?php
                                    $uid = $_SESSION ['userId'];
                                        
                                    $db = dbConnection("../../../");                                    
                                    $query_line = $db->query ( "SELECT lavoro_giornaliero.id_lavoro_giornaliero, lavoro_giornaliero.data, lavoro_giornaliero.descrizione
																FROM studente, studente_attends_classe, anno_scolastico, classe_has_stage, stage, classe, lavoro_giornaliero 
																WHERE studente.id_studente =  $uid
																AND anno_scolastico.corrente = 1 
																AND studente.scuola_id_scuola = classe.scuola_id_scuola 
																AND studente_attends_classe.studente_id_studente = studente.id_studente 
																AND studente_attends_classe.classe_id_classe  = classe.id_classe 
																AND studente_attends_classe.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico 
																AND classe_has_stage.classe_id_classe = classe.id_classe 
																AND classe_has_stage.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico 
																AND classe_has_stage.stage_id_stage = stage.id_stage 
																AND lavoro_giornaliero.studente_id_studente = studente.id_studente 
																AND lavoro_giornaliero.stage_id_stage = stage.id_stage 
																ORDER BY data DESC;");
                                        
                                    $Query = "SELECT AutorizzazioneRegistro FROM studente WHERE id_studente = $uid";
                                    $result = $db->query($Query);
                                    $row = $result->fetch_assoc();
                                    $autorizzazione = $row['AutorizzazioneRegistro'];
                                ?>
                                    
                            <input type="hidden" id="contatoreaggiungi" value="0">
                                
                            <div id="DescMain">
                                <div class="table-responsive"><table id="DescTable" class="table table-bordered" style="table-layout: fixed">
                                        <thead>
                                            <tr>
                                                <th style="width:15%">Data</th>
                                                <th style="width:65%">Descrizione</th>
                                                <?php if ($autorizzazione === "1") echo " <th>Azioni</th>"; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                            <?php
                                                            $I=0;
                                                while ($work_line = $query_line->fetch_assoc ()) 
                                                        {
                                            ?>
                                            <tr id="riga<?php echo $I ?>">
                                                <td id="data<?php echo $I ?>">
                                                                                    <?php echo $work_line['data']; ?>
                                                </td >
                                                <td class="regDesc" id="descrizione<?php echo $I ?>">
                                                                                    <?php echo $work_line['descrizione']; ?>
                                                </td>
                                                 <?php
                                                   if ($autorizzazione === "1") 
                                                    {   
                                                ?>
                                                <td class="regEdit">
                                                    
                                                    <div align="center" style=" vertical-align: middle">              
                                                        <input type="button" class="btn btn-info" id="modifica<?php echo $I ?>" name="<?php echo $work_line['id_lavoro_giornaliero']; ?>" value="Modifica" onclick = "openEdit(<?php echo $I ?>)">
                                                        <input type="button" class="btn btn-danger" id="elimina<?php echo $I ?>" name="<?php echo $work_line['id_lavoro_giornaliero']; ?>" value="Cancella" onclick = "deleteDescrizione(<?php echo $I ?>, this.name)">
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
                                    </table></div>
                            </div>
                                <?php
                                    if ($autorizzazione === "1")
                                    {   
                                ?>
                                    
                            <input type="button" name="<?php echo $I - 1 ?>" id="edit" class="btn btn-success" value="Aggiungi" onclick="appendAddingBox()">
                                
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