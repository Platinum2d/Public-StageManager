<?php
    include '../../functions.php';
    checkLogin(doctutType , "../../../");
    open_html ( "Registro" );
    $conn = dbConnection ("../../../");
    $id = $_POST ['id_studente'];
    $nome = $_POST ['nome_studente'];
    $cognome = $_POST ['cognome_studente'];
    import("../../../");
    /*echo "<script src='" . prj_pages . "/tutor/studenti/js/scripts.js'></script>";
    $sql = "select `visita_azienda` from `studente` where `id_studente`=$id";
    $Result = $conn->query ( $sql );
    $row = $Result->fetch_assoc ();
    $visita = $row ['visita_azienda'];
	*/
    
?>
<body>
	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
        printChat("../../..");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <a href="index.php"> Indietro </a>
                    <h1>Registro di <?php echo $cognome . " " . $nome; ?></h1>
                    <div class="row">
                        <div class="col col-sm-12">
                            <?php
                                    $query_line = $conn->query ( "SELECT * FROM `lavoro_giornaliero`
                                                                    WHERE `lavoro_giornaliero`.`studente_id_studente`=$id 
                                                                    ORDER BY `data` DESC;" );
                            ?>
                            <div id="DescMain">
                                <table id="DescTable" class="table table-striped table-bordered">
                                    <thead>
                                        <th style="min-width: 150px"> Data </th>
                                        <th> Descrizione </th>
                                    </thead>
                                    <tbody>
                            			<?php
                                            while ( $work_line = $query_line->fetch_assoc () ) {
                                                echo " 
                                                <tr> 
                                                    <td> ".$work_line['data']." </td>
                                                    <td class=\"regDesc\"> ".$work_line['descrizione']." </td>
                                                    <input type='hidden' class='descId' value='$work_line[id_lavoro_giornaliero]' />
                                                </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table> <br>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>
