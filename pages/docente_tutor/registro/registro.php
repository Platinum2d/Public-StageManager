<?php
    include '../../functions.php';
    checkLogin(doctutType , "../../../");
    open_html ( "Registro" );
    $conn = dbConnection ("../../../");
    $id = $_GET ['id_studente'];
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
					<h1>STUDENTI</h1>
					<div class="row">
						<div class="col col-sm-12">
                            <?php
							/*
                                if ($visita == 0) {
                                    
                                    echo <<<HTML
                                      <form method="POST" action="visita_ajax.php">                       
                                                                         
                                    <div id="prima">
                                        <h3>Lo studente si e presentatato in azienda per un colloquio?</h3>
                                    
                                        
                                        <input type="radio" name="scelta" value="1">si
                                        <input type="radio" name="scelta" value="0">no <br>
                                        <input type="submit" name="conferma_scelta" value="conferma" id="conferma_scelta" ><br>
                                        <input type="hidden" name="id_studente" value=$id>
                                        <input type="hidden" name="page" value="1">
                                    </div>
                                        </form>
HTML;
                                }
                                if ($visita >= 1) { */
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
                                        ?>
                            			<tr>
                            				<td><?php echo $work_line['data']; ?></td>
                            				<td class="regDesc"><?php echo $work_line['descrizione']; ?></td>
                            				<?php
                                                echo "<input type='hidden' class='descId' value='$work_line[id_lavoro_giornaliero]' />";
                                            ?>
                            			</tr>
                            			<?php
                                            }
                                        ?>
                            		</tbody>
                                </table> <br>
                                
                            </div>
                            <?php
								// }
                            ?>
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
