<?php
    include '../../../functions.php';
    checkLogin ( docrefType , "../../../../");
    open_html ( "Tutorato" );
    $conn = dbConnection ("../../../../");    
    import("../../../../");   
    $id_doc = $_SESSION ['userId'];
        
    $query = "SELECT * FROM anno_scolastico WHERE corrente = 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $id_anno_corrente = $row["id_anno_scolastico"];
    $nome_anno_corrente = $row["nome_anno"]; //prova
    echo '<script src="js/scripts.js"></script>';
?>
    
<body>
    <style>
        .tdlink{
            cursor: pointer;
        }
    </style>
   	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" style='min-height: 0'>
                    <h1 style="display: inline">I miei stage</h1> <br><br>
                        
                    <table class="table table-hover">
                        <thead>
                        	<tr>
                                <th class="col-sm-6 text-center">
                                    Nome classe
                                </th>
                                    
                                <th class="col-sm-6 text-center">
                                    Settore di studi
                                </th>
                            </tr>
                        </thead>
                            
                        <tbody style="text-align: center">
                            <?php
                                //$query = "SELECT DISTINCT c.id_classe, c.nome AS nomeclasse, sect.nome_settore FROM classe AS c, classe_has_docente AS chd, classe_has_stage AS chs , settore AS sect WHERE chd.classe_id_classe = c.id_classe AND chs.classe_id_classe = chd.classe_id_classe AND sect.id_settore = c.settore_id_settore AND chs.anno_scolastico_id_anno_scolastico = $id_anno_corrente AND chd.docente_id_docente = $id_doc";    
                                $query = "SELECT id_classe, nome AS nomeclasse, indirizzo_studi, nome_settore
                                            FROM docente_referente_has_classe_has_stage, classe_has_stage, classe, settore
                                            WHERE docente_referente_has_classe_has_stage.docente_id_docente = $id_doc 
                                            AND docente_referente_has_classe_has_stage.classe_has_stage_id_classe_has_stage = classe_has_stage.id_classe_has_stage
                                            AND classe_has_stage.classe_id_classe = classe.id_classe
                                            AND classe_has_stage.anno_scolastico_id_anno_scolastico = $id_anno_corrente 
                                            AND settore.id_settore = classe.settore_id_settore
                                            ORDER BY classe.nome;";
                                            
                                $result = $conn->query($query);
                                $I=0;
                                while ($row = $result->fetch_assoc())
                                {
                                   echo "<tr style=\"font-size : 20px\" id=\"riga$I\" onclick=\"redirectToDetails($I)\">  "
                                        . "<td class=\"tdlink\"> <form method=\"POST\" action=\"dettaglioesperienze/index.php\"> <input type=\"hidden\" name=\"classe\" value=\"".$row["id_classe"]."\"> <input type=\"hidden\" name=\"years\" value=\"".$id_anno_corrente."\"></form> ".$row["nomeclasse"]." </td> "
                                        . "<td class=\"tdlink\"> ".$row["indirizzo_studi"]." ".$row["nome_settore"]." </td> "
                                        . "</tr>";
                                            
                                   $I++;
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div align='right'>
                        <h3 style='display: inline'>A.S. <?php echo $nome_anno_corrente; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    close_html("../../../../");
?>