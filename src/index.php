<?php
    include "pages/functions.php";
    checkAccessDenied();
    checkVoto();
    checkEmail();
    open_html("Home");
    echo "<script src='".prj_pages."/login/scripts/login.js'></script>"
?>

<body>
    
    <?php
        topNavbar();    
        titleImg();     
    ?>

    <!-- Begin Body -->
	<!--<div class="container">
		<div class="row">
             <div class="col col-sm-3">
                <div id="sidebar">
                    <ul class="nav nav-stacked">
                        <li><h3 class="highlight">Channels <i class="glyphicon glyphicon-dashboard pull-right"></i></h3></li>
                        <li><a href="#">Link</a></li>
                        <li><a href="#">Link</a></li>
                    </ul>
                    <div class="accordion" id="accordion2">
                    	<div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                    Accordion
                                </a>
                            </div>
                            <div id="collapseOne" class="accordion-body collapse in">
                                <div class="accordion-inner">
                                  <p>There is a lot to be said about RWD.</p>
                                </div>
                            </div>
                        	</div>
                        <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                        Accordion
                                    </a>
                                </div>
                                <div id="collapseTwo" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                      <p>Use @media queries or utility classes to customize responsiveness.</p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div> -->
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="panel">
					<h2>Benvenuti!</h2>
						<p>
<!--							Questo è il sito che ospiterà il progetto di alternanza Scuola-Lavoro della classe 5^B, 
							dell'anno scolastico 2014/2015 dell'Istituto Primo Levi di Vignola. 
							<br> -->
                                                        Questo è il sito che ospita la piattaforma che digitalizza e valorizza l'esperienza di stage all'interno del progetto di Alternanza Scuola-Lavoro. Essa � stata completamente ideata e sviulpapta dalle classi 5B dell’Istituto Primo Levi di Vignola negli anni scolastici 2014/2015 e 2015/2016. Siamo partiti con l’idea di agevolare e semplificare le procedure e le pratiche burocratiche attinenti al rapporto tra Scuola e Azienda per quello che riguarda il periodo di Stage. Precedentemente si utilizzavano moduli cartacei che comportavano tempi e costi superiori. Oltre a facilitare il rapporto tra Scuola e Azienda, la nostra idea per il futuro di questo sito è quella di rendere accessibili i dati relativi agli anni precedenti per eseguire confronti, miglioramenti ed ulteriori sviluppi al periodo di Stage. 
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
                                        <a href="http://www.leviws.it/pages/login/forgottenpassword/index.php"style="color:#337ab7"> Ho dimenticato la mia password </a>
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
		<!-- </div>
	</div>-->
</body>
<?php
close_html();
?>