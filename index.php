<?php
    include "pages/functions.php";
    checkAccessDenied();
    import("");
    echo "<script src='sessione/login/scripts/login.js'></script>";
    open_html("Home");
?>
<body>
    <?php
        topNavbar("");    
        titleImg("");
    ?>
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="panel">
					<h2>Benvenuti!</h2>
						<p>
							Stage Manager è una piattaforma che digitalizza e valorizza l'esperienza 
							di stage all'interno dei progetti di Alternanza Scuola-Lavoro.
                            <br>
                            I primi passi sono stati percorsi all'interno dell’Istituto Primo Levi 
                            di Vignola. Siamo partiti con l’idea di agevolare e semplificare le 
                            procedure e le pratiche burocratiche attinenti al rapporto tra 
                            Scuola e Azienda per ciò che riguarda gli Stage didattici.
                            <br>
                            La nostra idea di software, oltre a facilitare il rapporto tra Scuola 
                            e Azienda, è una soluzione in grado di offrire la riduzione dello
                            spreco di tempo e denaro, ma soprattutto di fornire uno strumento di 
                            analisi in grado di migliorare le esperienze di Stage future.
						</p> 
						<br>
						<br>
						<br>
   						<?php
                              if (!isset($_SESSION['user'])){
                                   echo <<<HTML
                                   <div class="row">
                                        <h2 class="form-signin-heading centeredText">SIGN IN</h2>
                                        <div id="login" class="col col-sm-offset-2 col-sm-4 vcenter">
                                            <form onsubmit="check_login(); return false;">
                                                <br>
                                                <label for="username" class="sr-only">Username</label>
                                                <input id="username" type="text" class="form-control" placeholder="Username" required="">
                                                <br>
                                                <label for="password" class="sr-only">Password</label>
                                                <input id="password" type="password"class="form-control" placeholder="Password" required="">
                                                <br>
                                                <button id="loginButton" class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
                                            </form><br>
                                                <div id="forgottenPassword">  
                                        <a href="sessione/password-dimenticata/index.php"style="color:#337ab7"> Ho dimenticato la mia password </a>
                                    </div>
                                        </div>
                                        <div id="login-text" class="col col-sm-4 vcenter">
                                            &Egrave; necessario autenticarsi per poter accedere alle funzionalit&agrave; messe a disposizione da questa applicazione web.
                                        </div>
                                    </div>
HTML;
                                }
                            ?>
        		</div>
			</div>
		</div>
	</div>
</body>
<?php
	close_html("");
?>