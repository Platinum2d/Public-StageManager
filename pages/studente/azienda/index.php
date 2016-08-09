<?php
    include '../../functions.php';
    checkLogin ( studType , "../../../");
    open_html ( "Aziende disponibili" );
    import("../../../");
?>
<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");    
    ?>
    <!-- Begin Body -->
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="panel">
					<h1>Aziende disponibili</h1>
					<br>
					<div class="row">
						<div class="col col-sm-12">
                   			<?php
                                $conn = dbConnection("../../../");
                                echo <<<HTML
                                    <p>
                                        Elenco delle aziende:
                                    </p>
                                    <br>
HTML;
                                $output = $conn->query ( "SELECT `nome_aziendale`, `citta_aziendale`, `CAP`, `indirizzo`, `telefono_aziendale`, `email_aziendale`, `sito_web`, `nome_responsabile`, `cognome_responsabile`, `telefono_responsabile`, `email_responsabile` FROM `azienda` WHERE 1" );
                                // echo "SELECT `nome_aziendale`, `citta_aziendale`, `CAP`, `indirizzo`, `telefono_aziendale`, `e-mail_aziendale`, `sito_web`, `nome_responsabile`, `cognome_responsabile`, `telefono_responsabile`, `e-mail_responsabile` FROM `azienda` WHERE 1";
                                while ( $azienda = $output->fetch_assoc () ) {
                                    $nome_azienda = $azienda ['nome_aziendale'];
                                    $citta = $azienda ['citta_aziendale'];
                                    $cap = $azienda ['CAP'];
                                    $indirizzo = $azienda ['indirizzo'];
                                    $telefono_aziendale = $azienda ['telefono_aziendale'];
                                    $email = $azienda ['email_aziendale'];
                                    $sito = $azienda ['sito_web'];
                                    $nome_responsabile = $azienda ['nome_responsabile'];
                                    $cognome_responsabile = $azienda ['cognome_responsabile'];
                                    $telefono_responsabile = $azienda ['telefono_responsabile'];
                                    $email_responsabile = $azienda ['email_responsabile'];
                                    
                                    echo <<<HTML
                                        <br>
                                        <br>
                                        <table class="table table-striped">
                                            <tr>
                                                <th class="col-sm-5">Nome azienda</th>
                                                <td class="col-sm-5">$nome_azienda</td>
                                            </tr>
                                            <tr>
                                                <th>Città azienda</th>
                                                <td>$citta</td>
                                            </tr>
                                            <tr>
                                                <th>CAP</th>
                                                <td>$cap</td>
                                            </tr>
                                            <tr>
                                                <th>Indirizzo</th>
                                                <td>$indirizzo</td>
                                            </tr>
                                            <tr>
                                                <th>Telefono</th>
                                                <td>$telefono_aziendale</td>
                                            </tr>
                                            <tr>
                                                <th>E-mail</th>
                                                <td>$email</td>
                                            </tr>
                                            <tr>
                                                <th>Sito web</th>
                                                <td><a class="coloredLink" href="http://$sito" target="_blank">$sito</a></td>
                                            </tr>
                                            <tr>
                                                <th>Nome responsabile</th>
                                                <td>$nome_responsabile</td>
                                            </tr>
                                            <tr>
                                                <th>Cognome responsabile</th>
                                                <td>$cognome_responsabile</td>
                                            </tr>
                                            <tr>
                                                <th>Telefono responsabile</th>
                                                <td>$telefono_responsabile</td>
                                            </tr>
                                            <tr>
                                                <th>E-mail responsabile</th>
                                                <td>$email_responsabile</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <hr class="soften">
HTML;
                                }
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