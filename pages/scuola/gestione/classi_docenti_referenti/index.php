<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Classi e docenti referenti" );
    echo "<script src='scripts/script.js?8'></script>";
    import("../../../../");
    $conn = dbConnection("../../../../");
    $resultanno = $conn->query("SELECT * FROM anno_scolastico WHERE corrente = 1")->fetch_assoc();
    $nomeanno = $resultanno['nome_anno'];
    $idanno = $resultanno['id_anno_scolastico'];
    $idscuola = $_SESSION['userId'];
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
                            Classe
                        </th>
                        <th>
                            Docente referente assegnato
                        </th>
                        <th style="text-align:center">
                            Azioni
                        </th>
                        </thead>
                        <tbody>
                            <?php
                                $query = "  SELECT id_docente_has_classe_has_stage AS id_drhchs, doc.nome AS nomedocente, doc.cognome AS cognomedocente, classe.nome AS nomeclasse 
                                            FROM docente AS doc, docente_referente_has_classe_has_stage AS drhchs, classe_has_stage AS chs, classe 
                                            WHERE drhchs.docente_id_docente = doc.id_docente 
                                            AND chs.id_classe_has_stage = drhchs.classe_has_stage_id_classe_has_stage 
                                            AND classe.id_classe = chs.classe_id_classe 
                                            AND doc.scuola_id_scuola = $idscuola 
                                            AND chs.anno_scolastico_id_anno_scolastico = $idanno
                                            AND classe.scuola_id_scuola = $idscuola";
                                                                
                                $result = $conn->query($query);
                                if (is_object($result) && $result->num_rows > 0)
                                {
                                    $i = 0;
                                    while ($row = $result->fetch_assoc())
                                    {
                                        $nomedocente = $row['nomedocente'];
                                        $cognomedocente = $row['cognomedocente'];
                                        $nomeclasse = $row['nomeclasse'];
                                        $id_drhchs = $row['id_drhchs'];
                                        
                                        echo "<tr id='riga$i'>";
                                            echo "<td>$nomeclasse</td> <td>$nomedocente $cognomedocente</td> "
                                               . "<td align='center'><button onclick='askForDeleteAssignment($i, $id_drhchs, $idanno)' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Disassegna</button> </td>";
                                        echo "</tr>";
                                        
                                        $i++;
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