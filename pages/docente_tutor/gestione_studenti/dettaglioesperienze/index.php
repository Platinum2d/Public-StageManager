<?php
    include '../../../functions.php';
    checkLogin ( doctutType , "../../../../");
    open_html ( "Studenti" );
    $conn = dbConnection ("../../../../");    
    import("../../../../");
    echo "<script src=\"scripts.js\"> </script>";
    $id_doc = $_SESSION ['userId'];
        
    $id_anno = $_POST['anno'];
    $nome_anno = $_POST['nome_anno'];
    $id_classe = $_POST['classe'];
    $nome_classe = $_POST['nome_classe'];
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
                <div class="panel">
                    <h1> Studenti di <?php echo $nome_classe; ?> - A.S. <?php echo $nome_anno; ?></h1> <br>
                    <br>
                    <table class="table table-hover">
                        <thead>
                        <th style="text-align: center">
                            Cognome
                        </th>
                            
                        <th style="text-align: center;">
                            Nome
                        </th>
                        </thead>
                            
                        <tbody style="text-align: center">
                            <?php
                                //$query = "SELECT id_studente_has_stage, id_studente, nome, cognome FROM studente_has_stage AS shs, classe_has_stage AS chs, studente AS stud WHERE stud.id_studente = shs.studente_id_studente AND shs.docente_tutor_id_docente_tutor = $id_doc AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage AND chs.classe_id_classe = $id_classe AND chs.anno_scolastico_id_anno_scolastico = $id_anno GROUP BY stud.id_studente ORDER BY cognome";
                                $query = "SELECT s.id_studente, s.nome, s.cognome FROM studente AS s, studente_attends_classe as sas WHERE sas.studente_id_studente = s.id_studente AND sas.anno_scolastico_id_anno_scolastico = $id_anno AND sas.classe_id_classe = $id_classe";
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc())
                                {
                                    echo 
                                    "<tr style=\"font-size : 20px\"> "
                                        . "<td class=\"tdlink\"> "
                                            . "<form class=\"redirectform\" style=\"height : 0px\" action = \"dettaglio.php\" method = \"POST\">"
                                            . "<input type=\"hidden\" name=\"idc\" value=\"$id_classe\"> "
                                            . "<input type=\"hidden\" name=\"ida\" value=\"$id_anno\"> "
                                            . "<input type=\"hidden\" name=\"ids\" value=\" ".$row['id_studente']." \"> ".$row['cognome']." </form></td> "
                                        . "<td class=\"tdlink\">".$row['nome']."</td>"
                                    . " </tr>";
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
    close_html("../../../../");
?>