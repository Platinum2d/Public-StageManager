<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Classi e docenti referenti" );
    echo "<script src='scripts/script.js'></script>";
    import("../../../../");
    $conn = dbConnection("../../../../");
    $resultanno = $conn->query("SELECT * FROM anno_scolastico WHERE corrente = 1")->fetch_assoc();
    $nomeanno = $resultanno['nome_anno'];
    $idanno = $resultanno['id_anno_scolastico'];
?>

<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Gestione di docenti referenti e classi</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-2">
                            
                        </div>
                        <div class="col col-sm-4">
                            <span>Incarica</span>
                            <select onchange="loadValidClasses(<?php echo $idanno; ?>)" style="display: inline" class="form-control" id='addGestioneDocenteRef'>
                                
                                <?php
                                $query = "SELECT * FROM docente, utente WHERE id_utente = id_docente AND docente.scuola_id_scuola = ".$_SESSION['userId']." AND tipo_utente = ".docrefType;
                                $result = $conn->query($query);
                                if ($result && $result->num_rows > 0)
                                {
                                    while ($row = $result->fetch_assoc())
                                    {
                                        $id_docente = $row['id_docente'];
                                        $username = $row['username'];
                                        $nome_docente = $row['nome'];
                                        $cognome_docente = $row['cognome'];
                                            
                                        echo "<option value='$id_docente'>$cognome_docente $nome_docente</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col col-sm-4">
                            <span>di gestire, come docente referente, la classe*</span>
                            <select style="display: inline" class="form-control" id='addGestioneClasse'>
                                <?php
                                ?>
                            </select>
                            <button onclick="assignDocToClass(<?php echo $idanno; ?>)" class="btn btn-success rightAlignment margin"><span class="glyphicon glyphicon-ok"></span> Conferma</button>
                        </div>
                    </div>
                    <br><br>
                    <table class="table table-bordered" id='mainTable'>
                        <thead>
                        <th>
                            Classe assegnata
                        </th>
                        <th>
                            Docente referente assegnato
                        </th> 
                        <th>
                            Gestiti su Totali
                        </th> 
                        <th style="text-align:center">
                            Azioni
                        </th>
                        </thead>
                        <tbody>
                            <?php
                                $classesquery = "SELECT id_classe, nome FROM classe WHERE scuola_id_scuola = ".$_SESSION['userId'];
                                    
                                $resultclasses = $conn->query($classesquery);
                                while ($row = $resultclasses->fetch_assoc())
                                {
                                    $current_classe_id = $row['id_classe'];
                                    $current_nome_classe = $row['nome'];
                                        
                                                                            //quanti studenti ha la classe corrente in quest'anno
                                    $num_stud_current_class_query = "SELECT COUNT(sac.id_studente_attends_classe) AS count "
                                                                                 . "FROM studente_attends_classe AS sac "
                                                                                 . "WHERE sac.classe_id_classe = $current_classe_id "
                                                                                 . "AND sac.anno_scolastico_id_anno_scolastico = $idanno";                                        
                                    $num_stud_current_class = intval($conn->query($num_stud_current_class_query)->fetch_assoc()['count']);
                                        
                                    $docsquery = "SELECT id_docente, nome, cognome FROM utente, docente WHERE id_utente = id_docente AND tipo_utente = ".docrefType;
                                    $resultdocs = $conn->query($docsquery);
                                    while ($rowdocs = $resultdocs->fetch_assoc())
                                    {
                                        $current_docente_id = $rowdocs['id_docente'];
                                        $current_nome_docente = $rowdocs['nome'];
                                        $current_cognome_docente = $rowdocs['cognome'];
                                            
                                            
                                        //quanti studenti ha gestito il docente corrente in questa classe? Se è pari a $num_stud_current_class, allora è un docente referente di questa classe
                                        $num_stud_gestiti_current_doc_query = "SELECT COUNT(drhshs.id_docente_has_studente_has_stage) AS count 
                                                                                             FROM studente_has_stage AS shs, classe_has_stage AS chs, docente_referente_has_studente_has_stage AS drhshs 
                                                                                             WHERE drhshs.studente_has_stage_id_studente_has_stage = shs.id_studente_has_stage 
                                                                                             AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                                                                                             AND chs.classe_id_classe = $current_classe_id 
                                                                                             AND chs.anno_scolastico_id_anno_scolastico = $idanno 
                                                                                             AND drhshs.docente_id_docente = $current_docente_id;";
                                        $num_stud_gestiti_current_doc = intval($conn->query($num_stud_gestiti_current_doc_query)->fetch_assoc()['count']);
                                            
                                        //echo $current_cognome_docente . " " . $current_nome_docente . " gestisce ". $num_stud_gestiti_current_doc . " in ".$current_nome_classe. " su ".$num_stud_current_class. " totali<br>";
                                            
                                        if ($num_stud_current_class > 0 && $num_stud_gestiti_current_doc > 0)
                                        {
                                            echo "<tr><td align='center'>$current_nome_classe</td><td>$current_nome_docente $current_cognome_docente</td>"
                                                    . "<td align='center'><u style='cursor : pointer' onclick='showAssignedStudents($current_docente_id, $current_classe_id, $idanno)'>$num_stud_gestiti_current_doc su $num_stud_current_class</u></td>"
                                                    . "<td align='center'><button onclick='deleteAssignment($current_docente_id, $current_classe_id, $idanno)' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Disassegna</button></td></tr>";
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <div class='row'>
                        <div class="col col-sm-12">
                            <div class='row'>
                                <div class="col col-sm-4">
                                    * Non appaiono in lista classi vuote e/o senza esperienze di stage assegnate
                                </div>
                                <div class="col col-sm-8" align='right'>
                                    <h3>A.S. <?php echo $nomeanno; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        loadValidClasses(<?php echo $idanno; ?>);
    </script>
</body>
<?php
    close_html ("../../../../");
?>