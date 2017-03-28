<?php
    include '../../../functions.php';
    checkLogin ( doctutType , "../../../../");
    $conn = dbConnection ("../../../../");    
        
    $id_doc = $_SESSION ['userId'];
    $idanno = $_POST['ida'];
    $id_studente_has_stage = $_POST['studente_has_stage'];
    $query = "SELECT stud.nome, stud.cognome FROM studente AS stud, studente_has_stage AS shs WHERE shs.studente_id_studente = stud.id_studente AND shs.id_studente_has_stage = $id_studente_has_stage";
        
    $result = $conn->query($query)->fetch_assoc();
    $cognomestudente = $result['cognome'];
    $nomestudente = $result['nome'];
        
    $nomeanno = $conn->query("SELECT nome_anno AS nome FROM anno_scolastico WHERE id_anno_scolastico = $idanno")->fetch_assoc()['nome'];
        
    open_html ( "Registro di $cognomestudente $nomestudente" );
        
    import("../../../../");
    echo "<script src=\"scripts.js\"> </script>";
        
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
                    <h1> Registro di <?php echo $cognomestudente . " " . $nomestudente ?></h1> 
                    <br>
                    <div class="table-responsive">
                        <table class='table table-striped'>
                            <thead>
                            <th>
                                Data
                            </th>
                            <th>
                                Attività svolte
                            </th>
                            <th>
                                Capacità acquisite
                            </th>
                            <th>
                                Commento
                            </th>
                            </thead>
                                
                            <tbody>
                            <?php
                                $query = "SELECT * FROM lavoro_giornaliero WHERE studente_has_stage_id_studente_has_stage = $id_studente_has_stage";
                                $result = $conn->query($query);
                                    
                                if ($result->num_rows > 0)
                                {
                                    while ($row = $result->fetch_assoc())
                                    {
                                        $data = date("d-m-Y", strtotime($row['data']));
                                        $lavoro_svolto = $row['lavoro_svolto'];
                                        $insegnamenti = $row['insegnamenti'];
                                        $commento = $row['commento'];
                                            
                                        echo "<tr><td>$data</td>  <td>$lavoro_svolto</td><td>$insegnamenti</td><td>$commento</td></tr>";
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                        
                        
                    <br>
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
    close_html("../../../../");
?>