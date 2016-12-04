<?php
    include '../../functions.php';
    checkLogin ( doctutType , "../../../");
    open_html ( "Studenti" );
    $conn = dbConnection ("../../../");
    echo "<script src=\"scripts.js\"> </script>";
    import("../../../");   
    $id_doc = $_SESSION ['userId'];
        
    $query = "SELECT * FROM anno_scolastico WHERE corrente = 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $id_anno_corrente = $row["id_anno_scolastico"];
    $nome_anno_corrente = $row["nome_anno"]; //prova
?>
<body>
   	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Le mie classi - A.S. <?php echo $nome_anno_corrente; ?></h1> <br>
                    
                    <table class="table table-hover">
                        <thead>
                        <th style="text-align: center">
                            Nome classe
                        </th>
                        
                        <th style="text-align: center; width: 50%;">
                            Settore di studi
                        </th>
<!--                        
                        <th style="width: 15%; text-align: center">
                            Numero studenti
                        </th>-->
                        </thead>
                        
                        <tbody style="text-align: center">
                            <?php
                                $query = "SELECT DISTINCT c.id_classe, c.nome AS nomeclasse, sect.nome_settore FROM classe AS c, classe_has_docente AS chd, classe_has_stage AS chs , settore AS sect WHERE chd.classe_id_classe = c.id_classe AND chs.classe_id_classe = chd.classe_id_classe AND sect.id_settore = c.settore_id_settore AND chs.anno_scolastico_id_anno_scolastico = $id_anno_corrente AND chd.docente_id_docente = $id_doc";
                                    
                                $result = $conn->query($query);
                                $I=0;
                                while ($row = $result->fetch_assoc())
                                {
                                   echo "<tr id=\"riga$I\" onclick=\"redirectToDetails($I)\">  "
                                        . "<td> <form method=\"POST\" action=\"dettaglioesperienze/index.php\"> <input type=\"hidden\" name=\"shs\" value=\"\"> <input type=\"hidden\" name=\"classe\" value=\"".$row["id_classe"]."\"> <input type=\"hidden\" name=\"nome_classe\" value=\"".$row["nomeclasse"]."\"> <input type=\"hidden\" name=\"anno\" value=\"".$id_anno_corrente."\"> <input type=\"hidden\" name=\"nome_anno\" value=\"".$nome_anno_corrente."\"></form> ".$row["nomeclasse"]." </td> "
                                        . "<td> ".$row["nome_settore"]." </td> "
                                        . "</tr>";
                                            
                                   $I++;
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
    close_html("../../../");
?>