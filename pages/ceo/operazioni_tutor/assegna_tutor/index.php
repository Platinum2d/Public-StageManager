<?php
    include "../../../functions.php";
    checkLogin ( ceoType , "../../../../");
    open_html ( "Assegna tutor" );    
    import("../../../../");
    echo "<script src=\"scripts/script.js\"></script>";
    $conn = dbConnection ("../../../../");
    $query = "SELECT id_anno_scolastico, nome_anno FROM anno_scolastico WHERE corrente = 1";
    $resultanno = $conn->query($query)->fetch_assoc();
    $id_anno = $resultanno['id_anno_scolastico'];
    $nome_anno = $resultanno['nome_anno'];
    $id_azienda = $_SESSION['userId'];
?>
<style>
    .glyphicon-pencil:hover{
        cursor: pointer
    }
    
    .glyphicon-ok:hover{
        cursor: pointer;
    }
    
    .glyphicon-remove:hover{
        cursor: pointer;
    }
    
    .glyphicon-ok{
        font-weight: 14px;
    }
    
    .glyphicon-remove{
        font-weight: 14px;
    }
</style>

<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Assegnazione tutor (Anno scolastico <?php echo $nome_anno; ?>)</h1>
                    <table style="" class="table" id="maintable">
                        <thead >
                        <th style="text-align: center; width: 30%">
                            Studente
                        </th>
                        <th style="text-align: center; width: 20%">
                            Inizio
                        </th>
                        <th style="text-align: center; width: 20%">
                            Fine
                        </th>
                        <th style="text-align: center">
                            Tutor
                        </th>
                        </thead>
                        <tbody style="text-align: center">
                            <?php
                                $query =    "SELECT shs.id_studente_has_stage, stud.cognome, stud.nome, stud.id_studente, shs.tutor_id_tutor, inizio_stage, durata_stage FROM studente_has_stage AS shs, classe_has_stage AS chs, studente AS stud, stage 
                                            WHERE shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage AND 
                                            stud.id_studente = shs.studente_id_studente AND 
                                            chs.stage_id_stage = stage.id_stage AND
                                            chs.anno_scolastico_id_anno_scolastico = $id_anno AND 
                                            shs.azienda_id_azienda = $id_azienda ORDER BY  inizio_stage DESC, tutor_id_tutor ASC;
                                            ";
                                $result = $conn->query($query);
                                $I=0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $startdate = date('d/m/Y', strtotime($row['inizio_stage']));
                                    $enddate = date('d/m/Y', strtotime("+".$row['durata_stage']." days"));
                                    if (isset($row['tutor_id_tutor']) && !empty($row['tutor_id_tutor']))
                                    {
                                        $rowtutor = $conn->query("SELECT id_tutor, nome, cognome FROM tutor WHERE id_tutor = ".$row['tutor_id_tutor'])->fetch_assoc();
                                        $cognometutor = $rowtutor['cognome'];
                                        $nometutor = $rowtutor['nome'];
                                        $id_tutor = $row['tutor_id_tutor'];
                                            
                                    }
                                    else
                                    {
                                        $cognometutor = null;
                                        $nometutor = null;
                                        $id_tutor = -1;
                                    }
                                        
                                    $studente_has_stage = $row["id_studente_has_stage"];
                                    $id_studente = $row['id_studente'];
                                    echo "<tr";    
                                    if ($id_tutor !== -1) echo " class=\"success\"";
                                    echo " name=\"$studente_has_stage\"> <td><u style='cursor:pointer' onclick=\"userProfile($id_studente, '../../../')\">".$row['cognome']." ".$row['nome']."</u> </td> <td> $startdate </td> <td> $enddate </td> <td><div id=\"edit$I\" class=\"tutorwrapper\"> <span name=\"tutordata\">$cognometutor $nometutor </span> <span  style=\"color : orange\" class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\" onclick=\"editTutor(this, $I, $id_tutor, $studente_has_stage)\"></span></div></td></tr>";
                                        
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
    close_html ("../../../../");
?>