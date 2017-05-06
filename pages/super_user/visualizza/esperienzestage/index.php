<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Esperienze di stage" );
    import("../../../../");
    $conn = dbConnection("../../../../");
            
    $classe = $_POST['id_classe'];
    $anno = $_POST['years'];   
    if (!isset($classe) || !isset($anno)) 
    header (" Location : ../../../../index.php ");    
    
    $query = "SELECT nome FROM classe WHERE id_classe = $classe";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $nomeclasse = $row['nome'];
        
    $query = "SELECT nome_anno FROM anno_scolastico WHERE id_anno_scolastico = $anno";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $nomeanno = $row['nome_anno']
?>
<body>
 	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <script src="scripts/script.js?2"> </script>    
    <div class="container">
        
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" id = "mainPanel">
                    <h1> Esperienze di stage della <?php echo $nomeclasse; ?> </h1>    
                    <br>
                    <div class="row">
                        <div class="col col-sm-4">
                        </div>
                        <div class="col col-sm-4">
                            <select id='add' class="form-control">
                                <option value="-1"></option>
                                <?php
                                    $query = "SELECT * FROM stage WHERE id_stage NOT IN (SELECT stage_id_stage FROM classe_has_stage AS chs WHERE chs.classe_id_classe = $classe AND chs.anno_scolastico_id_anno_scolastico = $anno ) ORDER BY inizio_stage DESC";
                                    $result = $conn->query($query);
                                    while ($row = $result->fetch_assoc())
                                    {
                                        $inizio_stage = date("d-m-Y", strtotime($row['inizio_stage']));
                                        $fine_stage = date("d-m-Y", strtotime($row['fine_stage']));
                                        
                                        echo "<option value=\"".$row['id_stage']."\"> Inizio: $inizio_stage Fine: $fine_stage </option>";
                                    }
                                ?>
                            </select>
                            <button disabled="true" id="addButton" onclick="sendData(<?php echo $classe ?>, <?php echo $anno ?>, $('#add').val())" class="btn btn-success margin rightAlignment" style="display: block; margin-right: 0px">
                                <span class="glyphicon glyphicon-plus"></span> Aggiungi
                            </button>
                            
                        </div>
                    </div>
                        
                    <br>
                        
                    <table style="table-layout: fixed" class="table table-bordered table-responsive" id="table">
                        <thead style="background : #eee">
                        <th style="text-align : center; width: 50%">
                            Data di inizio
                        </th>
                        <th style="text-align : center">
                            Data di fine
                        </th>
                        <th style="text-align : center">
                            Azioni
                        </th>
                        </thead>
                            
                        <tbody>
                            <?php
                                $query = "SELECT id_classe_has_stage, inizio_stage, fine_stage FROM stage AS s, classe_has_stage AS chs WHERE s.id_stage = chs.stage_id_stage AND chs.classe_id_classe = $classe AND chs.anno_scolastico_id_anno_scolastico = $anno ORDER BY inizio_stage DESC";
                                    
                                $result = $conn->query($query);
                                $i = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $inizio_stage = date("d-m-Y", strtotime($row['inizio_stage']));
                                    $fine_stage = date("d-m-Y", strtotime($row['fine_stage']));
                                    $chs = $row['id_classe_has_stage'];
                                    
                                    echo "<tr data-progressiv = '$i'> "
                                    . "<td style=\"text-align : center\"><label> $inizio_stage </label></td> <td style=\"text-align : center\"> <label>$fine_stage</label> </td> "
                                    . " <td> "
                                        . "<div align=\"center\"> "
                                            . "<button id='edit$i' onclick='openEditModules($chs, $i)' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Modifica</button>  "
                                            . "<button style=\"margin : 0px\" name=\"delete\" onclick=\"deleteExperience($chs)\" class=\"btn btn-danger\"> <span class=\"glyphicon glyphicon-trash\"></span> Rimuovi </button>"
                                        . "</div> "
                                    . "</td> "
                                    . "</tr>";
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class='row'>
                        <div class="col col-sm-12">
                            <div class='row'>
                                <div align="left" class="col col-sm-4">
                                    <p>
<!--                                        Disassegnare un'esperienza o modificarne i moduli non eliminerà nessuna risposta data da aziende o studenti. 
                                        Esse, tuttavia, saranno irreperibili fino a quando non si riassegna il modulo tolto.-->
                                    </p>
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
</body>
    
<?php
    close_html ("../../../../");
?>