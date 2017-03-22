<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Insegnanti" );
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
    <script src="scritpts/script.js"></script>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Gestione degli insegnanti nelle classi</h1>
                    <br>
                        
                    <table class="table table-bordered">
                        <thead>
                        <th>
                            Classe
                        </th>
                        <th>
                            Indirizzo
                        </th>
                        <th>
                            Azioni
                        </th>
                        </thead>
                            
                        <tbody>
                        <?php
                        $query = "SELECT c.id_classe, c.nome AS nomeclasse, sect.nome_settore, sect.indirizzo_studi 
                                    FROM classe AS c, settore AS sect 
                                    WHERE c.settore_id_settore = sect.id_settore
                                    AND c.scuola_id_scuola = ".$_SESSION['userId'];
                        $result = $conn->query($query);
                        if ($result && $result->num_rows > 0)
                        {
                            $I=0;
                            while ($row = $result->fetch_assoc())
                            {
                                $idclasse = $row['id_classe'];
                                $nomeclasse = $row['nomeclasse'];
                                $indirizzostudi = $row['indirizzo_studi'];
                                $nomesettore = $row['nome_settore'];
                                    
                                echo "<tr id='riga$I'>";
                                echo "<td align='center'>$nomeclasse</td><td align='center'>$indirizzostudi $nomesettore</td>"
                                   . "<td align='center'><button id='info$I' onclick='$(this).prop(\"disabled\", true); openInfo($I, \"$nomeclasse\", $idclasse, $idanno);' class='btn btn-success'><span class='glyphicon glyphicon-info-sign'></span> Visualizza</button></td>";
                                echo "</tr>"; 
                                $I++;
                            }                            
                        }
                        ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class='row'>
                        <div class="col col-sm-12">
                            <div class='row'>
                                <div class="col col-sm-4">
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