<?php
    include '../../../../functions.php';
    checkLogin ( docrefType , "../../../../../");
    
    $conn = dbConnection ("../../../../../");    

    $id_doc = $_SESSION ['userId'];
        
    $idstudente = $_POST['ids'];
    $idanno = $_POST['ida'];
    $idclasse = $_POST['idc'];
    
    $query = "  SELECT id_studente_has_stage, tut.nome, tut.cognome, az.nome_aziendale, st.inizio_stage, st.fine_stage
                FROM studente_has_stage AS shs, tutor AS tut, azienda AS az, stage AS st, classe_has_stage AS chs 
                WHERE shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                AND shs.tutor_id_tutor = tut.id_tutor 
                AND shs.azienda_id_azienda = az.id_azienda
                AND chs.stage_id_stage = st.id_stage 
                AND chs.classe_id_classe = $idclasse 
                AND chs.anno_scolastico_id_anno_scolastico = $idanno 
                AND shs.docente_tutor_id_docente_tutor = $id_doc 
                AND shs.studente_id_studente = $idstudente";
    
    $cognomestudente = $conn->query("SELECT cognome FROM studente WHERE id_studente = $idstudente")->fetch_assoc()['cognome'];
    $nomestudente = $conn->query("SELECT nome FROM studente WHERE id_studente = $idstudente")->fetch_assoc()['nome'];
    $nomeanno = $conn->query("SELECT nome_anno AS nome FROM anno_scolastico WHERE id_anno_scolastico = $idanno")->fetch_assoc()['nome'];
    
    import("../../../../../");
    echo "<script src=\"js/scripts.js\"> </script>";
    open_html ( "Esperienze di $cognomestudente $nomestudente" );
?>
    
<body>
    <style>
        .tdlink{
            cursor: pointer;
        }
    </style>
   	<?php
        topNavbar ("../../../../../");
        titleImg ("../../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" style='min-height: 0'>
                    <form id='rForm' action="registro.php" method='POST' target="_blank">
                        <input name='ida' type='hidden' value="<?php echo $idanno; ?>">
                    </form>
                    
                    <h1> Esperienze di stage di <u onclick="userProfile(<?php echo $idstudente ?>, '../../../')" style="cursor: pointer"><?php echo $cognomestudente . " " . $nomestudente ?></u></h1> <br>
                        
                    <div class="row">
                        <div class="col col-sm-4">
                            
                        </div>
                            
                        <div class="col col-sm-4">
                            Desidero visualizzare<select class="form-control" id="destination">
                                <option value="registro">Registro</option>
                                <option value="valutazionestud">Valutazione dello studente</option>
                                <option value="valutazioneaz">Valutazione  dell'azienda</option>
                            </select> 
                        </div>
                            
                        <div class="col col-sm-4">                   
                        </div>
                    </div>
                    <br>
                    <table class="table table-hover">
                        <thead>
                        	<tr>
                                <th style="text-align: center">
                                    Data di inizio stage
                                </th>
                                    
                                <th style="text-align : center" style="text-align: center;">
                                    Data di fine stage
                                </th>
                                    
                                <th style="text-align : center" style="text-align: center;">
                                    Azienda
                                </th>
                                    
                                <th style="text-align : center" style="text-align: center;">
                                    Tutor
                                </th>
                                    
                                <th style="text-align: center;">
                                    Azioni
                                </th>
                        	</tr>
                        </thead>
                            
                        <tbody style="text-align: center">
                            <?php
                            $studente_has_stage_query = "SELECT id_studente_has_stage 
                                                        FROM studente_has_stage AS shs, classe_has_stage AS chs 
                                                        WHERE shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage                                                         
                                                        AND shs.docente_tutor_id_docente_tutor = ".$id_doc." 
                                                        AND shs.studente_id_studente = $idstudente 
                                                        AND chs.classe_id_classe = $idclasse     
                                                        AND chs.anno_scolastico_id_anno_scolastico = $idanno";
                            $result = $conn->query($studente_has_stage_query);
                            if ($result && $result->num_rows > 0)
                            {
                                $I = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $current_stage = $row['id_studente_has_stage'];
                                    $tutor_query = "SELECT tut.id_tutor, tut.nome AS nometutor, tut.cognome AS cognometutor FROM tutor AS tut, studente_has_stage AS shs WHERE shs.tutor_id_tutor = tut.id_tutor AND shs.id_studente_has_stage = $current_stage";
                                    $azienda_query = "SELECT az.id_azienda, az.nome_aziendale FROM azienda AS az, studente_has_stage AS shs WHERE shs.azienda_id_azienda = az.id_azienda AND shs.id_studente_has_stage = $current_stage";
                                    $stage_query = "SELECT st.id_stage, st.inizio_stage, st.fine_stage 
                                                    FROM stage AS st, studente_has_stage AS shs, classe_has_stage AS chs
                                                    WHERE shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                                                    AND chs.stage_id_stage = st.id_stage 
                                                    AND shs.id_studente_has_stage = $current_stage";
                                    
                                    $tutor_result = $conn->query($tutor_query);
                                    if ($tutor_result && $tutor_result->num_rows > 0)
                                    {
                                        $tutor_result = $tutor_result->fetch_assoc(); 
                                        $id_tutor = $tutor_result['id_tutor'];
                                        $nome_tutor = $tutor_result['nometutor'];
                                        $cognome_tutor = $tutor_result['cognometutor'];
                                    }
                                    else
                                    {
                                        $id_tutor = "-1";
                                        $nome_tutor = "";
                                        $cognome_tutor = "";
                                    }
                                    
                                    $azienda_result = $conn->query($azienda_query);
                                    if ($azienda_result && $azienda_result->num_rows > 0)
                                    {
                                        $azienda_result = $azienda_result->fetch_assoc(); 
                                        $id_azienda = $azienda_result['id_azienda'];
                                        $nome_azienda = $azienda_result['nome_aziendale'];
                                    }
                                    else
                                    {
                                        $id_azienda = "-1";
                                        $nome_azienda = "";
                                    }
                                    
                                    $stage_result = $conn->query($stage_query);
                                    if ($stage_result && $stage_result->num_rows > 0)
                                    {
                                        $stage_result = $stage_result->fetch_assoc(); 
                                        $id_stage = $stage_result['id_stage'];
                                        $inizio_stage = $stage_result['inizio_stage'];
                                        $fine_stage = $stage_result['fine_stage'];
                                    }
                                    else
                                    {
                                        $id_stage = "-1";
                                        $inizio_stage = "";
                                        $fine_stage = "";
                                    }
                                    
                                    echo "<tr id=\"riga$I\" style=\"font-size : 20px\"> "
                                            . "<td>".date("d-m-Y", strtotime($inizio_stage))."</td> "
                                            . "<td>".date('d-m-Y', strtotime($fine_stage))."</td>"
                                            . "<td>$nome_azienda</td>"
                                            . "<td>$cognome_tutor $nome_tutor</td> "
                                            . "<td><div align=\"center\">"
                                            . "<button onclick=\"establishDestination($I, ".$row['id_studente_has_stage'].")\" id=\"dettagli$I\" style=\"margin : 0px\" class=\"btn btn-success\"> <span class=\"glyphicon glyphicon-circle-arrow-right\"></span> Visualizza </button></div></td></tr>";
                                           
                                    $I++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div align='right'>
                        <h3 style='display: inline'>A.S. <?php echo $nomeanno; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    close_html("../../../../../");
?>