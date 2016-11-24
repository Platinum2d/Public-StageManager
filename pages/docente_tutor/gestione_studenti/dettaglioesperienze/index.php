<?php
    include '../../../functions.php';
    checkLogin ( doctutType , "../../../../");
    open_html ( "Studenti" );
    $conn = dbConnection ("../../../../");
    echo "<script src=\"script/script.js\"> </script>";
    import("../../../../");
    $id_doc = $_SESSION ['userId'];
    
    $id_anno = $_POST['anno'];
    $nome_anno = $_POST['nome_anno'];
    $id_classe = $_POST['classe'];
    $nome_classe = $_POST['nome_classe'];
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
                    <h1> Studenti di <?php echo $nome_classe; ?> - A.S. <?php echo $nome_anno; ?></h1> <br>
                    
                    <div class="row">
                        <div class="col col-sm-4"> </div>
                        <div class="col col-sm-4">              
                            Desidero visualizzare 
                            <select class="form-control"> 
                                <option value="registro"> Registro delle attività </option>
                                <option value="valutazioneazienda"> Valutazione dell'azienda </option>
                                <option value="valutazionestudente"> Valutazione dello studente </option>
                            </select> </div>
                        <div class="col col-sm-4"> </div>
                    </div>
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
                                $query = "SELECT id_studente_has_stage, id_studente, nome, cognome FROM studente_has_stage AS shs, classe_has_stage AS chs, studente AS stud WHERE stud.id_studente = shs.studente_id_studente AND shs.docente_id_docente = $id_doc AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage AND chs.classe_id_classe = $id_classe AND chs.anno_scolastico_id_anno_scolastico = $id_anno GROUP BY stud.id_studente ORDER BY cognome";
                                //ECHO $query;
                                $result = $conn->query($query);
                                while ($row = $result->fetch_assoc())
                                {
                                    echo 
                                    "<tr> "
                                        . "<td><form action=\"\" method=\"POST\"> <input type=\"hidden\" name=\"id_studente_has_stage\" value=\"".$row['id_studente_has_stage']."\" /> <input type=\"hidden\" name=\"id_studente\" value=\"".$row['id_studente']."\" /> </form>  ".$row['cognome']."</td> "
                                        . "<td>".$row['nome']."</td>"
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
    close_html();
?>