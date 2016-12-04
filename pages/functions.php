<?php
    session_start ();
//    define ( "prj_root", "/" ); //contiene il percorso alla cartella root del progetto (/alternanza_scuola lavoro)
//    define ( "prj_pages", prj_root . "pages" ); //contiene il percorso alla cartella pages
//    define ( "prj_src", prj_root . "src" ); //contiene il percorso alla cartella src
//    define ( "prj_img", prj_src . "/img" ); //contiene il percorso alla cartella img 
//    define ( "prj_lib", prj_src . "/lib" ); //contiene il percorso alla cartella lib
    
    define ( "superUserType", 0 );
    define ( "adminType", 1 ); //contiene il valore corrispondente all'utente admin
    define ( "docrefType", 2 ); //contiene il valore corrispondente all'utente docente referente
    define ( "doctutType", 3 ); //contiene il valore corrispondente all'utente docente tutor
    define ( "ceoType", 4 ); //contiene il valore corrispondente all'utente ceo
    define ( "aztutType", 5 ); //contiene il valore corrispondente all'utente tutor azienda
    define ( "studType", 6 ); //contiene il valore corrispondente all'utente studente 
    
    define ( "err_noLog", 1 ); //contiene il valore relativo all'errore corrispondente all'utente che cerca di accedere ad una pagina senza essersi loggato
    define ( "err_noPerm", 2 ); //contiene il valore relativo all'errore corrispondente all'utente che cerca di accedere ad una pagina per la quale non ha i permessi necessari (pagina per un altro utente)
        
    define ( "sended", 2);  //contiene il valore corrispondente ad un email correttamente inviata
    define ( "notSended", 1);   //contiene il valore corrispondente ad un email non correttamente inviata
        
    function dbConnection($goBack) // connessione al database 'alternanza_scuola_lavoro' come utente root. ritorna un alert con il messaggi od ierrore se la connessione non è riuscita
    { 
        if (!file_exists($goBack."db.txt") || !file_exists($goBack."okuser.txt")) { 
            echo $goBack."install/index.php";
            header ( "Location: ".$goBack."install/index.php" );
        }
            
        if (!isset($_SESSION['dbhost']) || !isset($_SESSION['dbuser']) || !isset($_SESSION['dbpassword']) || !isset($_SESSION['dbname']))
        {
            $recoveredData = file_get_contents("".$goBack."db.txt");
            $recoveredArray = unserialize($recoveredData);
            $_SESSION['dbhost'] = $recoveredArray['host'];
            $_SESSION['dbuser'] = $recoveredArray['user'];
            $_SESSION['dbpassword'] = $recoveredArray['password'];
            $_SESSION['dbname'] = $recoveredArray['name'];
            $connessioneforuse = new mysqli($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpassword'],$_SESSION['dbname']);
            $connessioneforuse->query("USE ".$_SESSION['dbname']);
        }
            
        $connessione = new mysqli($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpassword'],$_SESSION['dbname']);
            
        if ($connessione->connect_error) 
        {
            $message = $connessione->connect_errno;
            echo "<script type='text/javascript'>alert('$message');</script>";
        } 
        else
        {
            return $connessione;
        }
    }
        
    function horizontalNavbar($goBack) { // aggiunge la barra di navigazione in base all'utente loggato

        echo <<<HTML
                    <ul class="nav navbar-nav">
HTML;
            echo "<li><a href='".$goBack."index.php'>Home</a></li>";
        if (! isset ( $_SESSION ['type'] )) {
            echo <<<HTML
                    </ul>      
HTML;
        } else {
            
            if ($_SESSION ['type'] == superUserType) { // se e' loggato amministratore
                echo "<script> $(\".dropdown-toggle .dropdown .dropdown-hover .open\").click(function (){ location.href = \"".$goBack."pages/admin/inserimento/index.php\" }) </script>";
//                 echo "<ul class=\"nav navbar-nav\"> ";
//                 //echo "<li> <span class=\"glyphicon glyphicon-question-sign\" aria-hidden=\"true\"></span> </li>";
//                 echo "<li><a href='".$goBack."index.php'>Home</a></li>";
                echo " <li><a href='".$goBack."pages/admin/profiloutente/index.php'>Profilo</a></li>";
                echo "<li class=\"dropdown dropdown-hover\">";
                echo "<a href=\"".$goBack."pages/admin/inserimento/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Inserimento<span class=\"caret\"></span></a><ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\">";
                    
                echo " <li><a href='".$goBack."pages/admin/inserimento/anniscolastici/index.php'>Anni Scolastici</a></li>";  
                echo " <li><a href='".$goBack."pages/admin/inserimento/aziende/index.php'>Aziende</a></li>";  
                echo " <li><a href='".$goBack."pages/admin/inserimento/classi/index.php'>Classi</a></li>";
                echo " <li><a href='".$goBack."pages/admin/inserimento/docenti/index.php'>Docenti</a></li>";
                echo " <li><a href='".$goBack."pages/admin/inserimento/figureprofessionali/index.php'>Figure Professionali</a></li>";
                echo " <li><a href='".$goBack."pages/admin/inserimento/scuole/index.php'>Scuole</a></li>";
                echo " <li><a href='".$goBack."pages/admin/inserimento/settori/index.php'>Settori</a></li>";
                echo " <li><a href='".$goBack."pages/admin/inserimento/stage/index.php'>Stage</a></li>";  
                echo " <li><a href='".$goBack."pages/admin/inserimento/studenti/index.php'>Studenti</a></li>";                
                echo " <li><a href='".$goBack."pages/admin/inserimento/tutor/index.php'>Tutor</a></li>";                
                echo "</ul></li>";
                echo "<li class=\"dropdown dropdown-hover\">";                
                echo "<a href=\"".$goBack."pages/admin/visualizza/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Visualizza<span class=\"caret\"></span></a>";
                echo "<ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\">";
                echo " <li><a href='".$goBack."pages/admin/visualizza/aziende/index.php'>Aziende</a></li>";
                echo " <li><a href='".$goBack."pages/admin/visualizza/newclassi/index.php'>Classi</a></li>";
                echo " <li><a href='".$goBack."pages/admin/visualizza/docenti/index.php'>Docenti</a></li>";
                echo " <li><a href='".$goBack."pages/admin/visualizza/tutor/index.php'>Tutor</a></li>";
                echo "</ul></li>";
//                                echo <<<HTML
//                        <li class="dropdown dropdown-hover">
//                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Anno Scolastico <span class="caret"></span></a>
//                                        <ul class="dropdown-menu dropdown-menu-hover" role="menu">
//                                            
//HTML;
//                    echo " <li><a href='javascript:changeDatabase(\"1\");'> 2015/2016 </a></li>";
//                    echo " <li><a href='javascript:changeDatabase(\"2\");'> 2014/2015 </a></li>";
//                echo "</ul></li>";
                echo "</ul>"; 
                    
            } elseif ($_SESSION ['type'] == docrefType) { // se e' loggato docente referente
//                 echo <<<HTML
//                     <ul class="nav navbar-nav">  
// HTML;
//                 //echo "<li> <a> <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\">guida</span> </a></li>";
//                echo "<li><a href='".$goBack."index.php'>Home</a></li>"; 
                echo "<li><a href='".$goBack."pages/docente_referente/profiloutente/index.php'>Profilo</a></li>";
                echo <<<HTML
                    </ul>      
HTML;
            } elseif ($_SESSION ['type'] == doctutType) { // se è loggato docente tutor
//                 echo <<<HTML
//                     <ul class="nav navbar-nav">  
// HTML;
//                echo "<li><a href='".$goBack."index.php'>Home</a></li>"; 
                echo "<li><a href='".$goBack."pages/docente_tutor/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/docente_tutor/gestione_studenti/index.php'>Le mie classi</a></li>";
		echo "<li><a href='".$goBack."pages/docente_tutor/contatta/index.php'>Contatta</a></li>";		
                echo <<<HTML
                    </ul>      
HTML;
            } elseif ($_SESSION ['type'] == ceoType) { // se è loggato responsabile impresa
//                 echo <<<HTML
//                     <ul class="nav navbar-nav">  
// HTML;
//                 echo "<li><a href='".$goBack."index.php'>Home</a></li>"; 
                echo "<li><a href='".$goBack."pages/ceo/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/ceo/la_mia_azienda/index.php'>La mia azienda</a></li>";
                                                echo <<<HTML
                        <li class="dropdown dropdown-hover">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Tutor <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-hover" role="menu">
                                            
HTML;
                echo "<li><a href='".$goBack."pages/ceo/assegna_tutor/index.php'>Assegna Tutor</a></li>";
                echo "<li><a href='".$goBack."pages/ceo/inserisci_tutor/index.php'>Inserisci Tutor</a></li>";
                echo "<li><a href='".$goBack."pages/ceo/modifica_tutor/index.php'> Visualizza Tutor </a></li>";
                echo "</ul></li>";
                echo "<li><a href='".$goBack."pages/ceo/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                    </ul>      
HTML;
            } elseif ($_SESSION ['type'] == aztutType) { // se è loggato tutor aziendale
//                 echo <<<HTML
//                     <ul class="nav navbar-nav">  
// HTML;
//                 echo "<li><a href='".$goBack."index.php'>Home</a></li>"; 
                echo "<li><a href='".$goBack."pages/tutor/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/tutor/studenti/index.php'>Studenti</a></li>";
                echo "<li><a href='".$goBack."pages/tutor/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                    </ul>      
HTML;
            } elseif ($_SESSION ['type'] == studType) { // se è loggato studente
//                 echo <<<HTML
//                     <ul class="nav navbar-nav">  
// HTML;
//                 echo "<li><a href='".$goBack."index.php'>Home</a></li>"; 
                echo "<li><a href='".$goBack."pages/studente/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/studente/il_mio_stage/index.php'>Il mio stage</a></li>";
                echo "<li><a href='".$goBack."pages/studente/registro/index.php'>Registro</a></li>";
                echo "<li><a href='".$goBack."pages/studente/voto/index.php'>Voto</a></li>";
                echo "<li><a href='".$goBack."pages/studente/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                    </ul>      
HTML;
            } 
        }
    }
        
    function loginButton($goBack) { // conferma delle credenziali per il login
        if (isset ( $_SESSION ['user'] )) 
        {
                        echo <<<HTML
                <li class="button">
HTML;
            echo "<a href='" . $goBack . "pages/destroyer.php'><i class='glyphicon glyphicon-user'></i> Logout</a>";
            echo "<li>";
        }
    }
        
    function checkLogin($type, $goBack) { // controllo del login
        if (! isset ( $_SESSION ['type'] )) {
            
            $_SESSION ['access_denied'] = err_noLog;
            header ( "location: ".$goBack."index.php" );
        } elseif ($_SESSION ['type'] != $type) {
            $_SESSION ['access_denied'] = err_noPerm;
            header ( "location: ".$goBack."index.php" );
        }
    }
        
    function title($goBack) { //imposta il titolo della pagina        
//         echo <<<HTML
//            <div class="col col-sm-8">
// HTML;
//         echo "<h1><a href='".$goBack."index.php' title='Alternanza Scuola-lavoro'> Piattaforma Alternanza Scuola-Lavoro</a></h1>";
//         echo <<<HTML
//               </div>
//     	echo <<<HTML
//               <div class="col col-sm-12">
//                 <div id="logo">
// HTML;
//         echo "<a href='".$goBack."' title='Stage Manager'>";
//         echo "<img src='".$goBack."src/img/logo_stage_manager.png' alt='Stage Manager'></a>";
//         echo <<<HTML
//               </div>
//               </div>
// HTML;
    }
        
    function immagineLevi($goBack) { // inserisce l'immagine di header del sito
        echo <<<HTML
         <div class="col col-sm-12">
HTML;
        echo "<img class='img-responsive' src='".$goBack."src/img/IMG_2455.jpg' alt=''' width='100%' height='326' />";
        echo <<<HTML
              </div>
HTML;
    }
        
    function rightButtons($goBack) { // bottoni in alto a destra nella barra di navigazione
        echo <<<HTML
            <ul class="nav navbar-right navbar-nav">
                  <li class="dropdown">
HTML;
    
            if (isset($_SESSION['type']))
            {
                if ($_SESSION['type'] !== superUserType)
                {
                    echo "<a href=\"".$goBack."contattaci.php\" > Contattaci </a>";
                    if (isset($_SESSION ['type'])) 
                    echo "<li class=\"button\"> <a href=\"".$goBack."pages/valutazione/index.php\"> Valutaci </a> </li>";
                }
                else
                {
                    echo "<li class=\"button\"> <a href=\"".$goBack."pages/admin/impostazioni/index.php\"><i class=\"glyphicon glyphicon-cog\"></i>  Impostazioni </a></li>";
                }
            }                   
            
            echo "</li>";
            echo "<li class=\"button\"> <a href=\"".$goBack."manuale.pdf\"> Manuale </a></li>";
            loginButton ($goBack);
            echo"</li></ul>";
    }
        
    function topNavbar($goBack) {  // barra di navigazione che contiene sia la barra orizzontale che i bottoni
//         printBadge($goBack);
        if (!file_exists($goBack."db.txt") || !file_exists($goBack."okuser.txt")) { 
            echo $goBack."install/index.php";
            header ( "Location: ".$goBack."install/index.php" );
        }

        echo "<div class='container'><div id='logo-row' class='row parent-max-height'><div class='col col-sm-3'><a href='".$goBack."' title='Stage Manager'><img class='logo img-responsive' src='".$goBack."src/img/logo_stage_manager.png' alt='Stage Manager'></a></div>";
        echo "<div id='title' class='col col-sm-9 pull-right child-max-height'><h1>Stage Manager</h1></div></div></div>";
        echo <<<HTML
        <nav class="navbar navbar-static">
            <div class="container">
              <a class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                <span class="glyphicon glyphicon-chevron-down"></span>
              </a>
              <div class="nav-collapse collase">
HTML;
        horizontalNavbar ($goBack);
        rightButtons ($goBack);
        echo <<<HTML
                  </div>		
            </div>
        </nav>
HTML;
    }
        
    function titleImg($goBack) { //titolo immagine 
        echo <<<HTML
         <header class="masthead">
          <div class="container">
            <div class="row">
HTML;
        title ($goBack);
        immagineLevi ($goBack);
            
        echo <<<HTML
            </div>
          </div>    <!--header-->
              
        </header>
HTML;
    }
        
    function import($goBack) { //importa librerie
        echo "<link href='".$goBack."src/lib/bootstrap-3.3.4-dist/css/bootstrap.min.css' rel='stylesheet'>";
        echo "<link href='".$goBack."src/lib/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css' rel='stylesheet'>";
        echo <<<HTML
HTML;
        echo "<script src=\"".$goBack."pages/scripts.js\"> </script>";
        echo "<script src='".$goBack."src/lib/jQuery/jquery-2.2.3.min.js'></script>";
        echo "<script src='".$goBack."src/lib/bootstrap-3.3.4-dist/js/bootstrap.min.js'></script>";
        echo "<script src='".$goBack."src/lib/bootstrap-filestyle/bootstrap-filestyle.min.js'></script>";
        echo "<link href='".$goBack."src/lib/custom/css/styles.css' rel='stylesheet'>";
        echo "<script src='".$goBack."src/lib/jquery-te/jquery-te-1.4.0.min.js'></script>";
        echo "<link href='".$goBack."src/lib/jquery-te/jquery-te-1.4.0.css' type'text/css' rel='stylesheet'>";
        echo "<script src='".$goBack."src/lib/jquery-ui-1.11.4/jquery-ui.min.js'></script>";
        echo "<link href='".$goBack."src/lib/jquery-ui-1.11.4/jquery-ui.min.css' type'text/css' rel='stylesheet'>";
        echo "<link href='".$goBack."src/lib/custom/css/custom.css' rel='stylesheet'>";
        echo "<link href='".$goBack."src/lib/badger/badger.css' rel='stylesheet'>";
        echo "<script src='".$goBack."src/lib/custom/js/scripts.js'></script>";
        echo "<script src='".$goBack."src/lib/badger/badger.js'></script>";
        echo "<script src='".$goBack."src/lib/jquery.fileDownload-master/index.js'></script>";
        echo "<script src='".$goBack."src/lib/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js'></script>";
        echo "<link href='".$goBack."src/lib/custom/buttonfix.css' rel='stylesheet'>";
        echo "<link rel='icon' type='image/png' href='".$goBack."src/img/favicon.png'>";
        echo "<link href='".$goBack."src/lib/bootstrap-select-1.10.0/dist/css/bootstrap-select.min.css' rel='stylesheet'>";
        echo "<script src='".$goBack."src/lib/bootstrap-select-1.10.0/js/bootstrap-select.js'></script>";
        echo "<script src='".$goBack."src/lib/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.js'></script>";
        echo "<link href='".$goBack."src/lib/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css' rel='stylesheet'>";
        echo "<script src='".$goBack."src/lib/chat-0.0.1/chat.js'></script>";
        echo "<link href='".$goBack."src/lib/chat-0.0.1/style.css' rel='stylesheet'>";
        $uploaderpath = $goBack."src/lib/jQuery-File-Upload";
    }
        
    function open_html($title) { // apre la pagina con il relativo titolo       
        
        echo <<<HTML
            <html lang="it">
                    <head>
                            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                            <meta charset="utf-8">
                                
                            <title>$title</title>
                            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
HTML;
        echo <<<HTML
                    </head>
HTML;
    }
        
        
    function close_html($goBack) { //chiude la pagina
        footer($goBack);
        echo <<<HTML
         </html>
HTML;
    }
        
    function checkAccessDenied() { //accesso non consentito e stampa del messaggio di avvertimento
        if (isset ( $_SESSION ['access_denied'] )) {
            if ($_SESSION ['access_denied'] = err_noLog) {
                echo <<<HTML
                <script>alert("Loggati per poter accedere a questa pagina.");
                </script>
HTML;
                unset ( $_SESSION ['access_denied'] );
            } elseif ($_SESSION ['access_denied'] = err_noPerm) {
                echo <<<HTML
                <script>alert("Non hai i permessi necessari per accedere a questa pagina.");
                </script>
HTML;
                unset ( $_SESSION ['access_denied'] );
            }
        }
    }
        
    function checkEmail() { //controllo email e stampa se il messaggio è stato inviato correttamente o no
        if (isset ( $_SESSION ['email_sent'] )) {
            if ($_SESSION ['email_sent'] == 2) {
                echo <<<HTML
                <script>alert("L'e-mail e' stata inviata con successo.");
                </script>
HTML;
                unset ( $_SESSION ['email_sent'] );
            } else {
                if ($_SESSION ['email_sent'] == 1) {
                    echo <<<HTML
                <script>alert("L'e-mail NON e' stata inviata correttamente.");
                </script>
HTML;
                    unset ( $_SESSION ['email_sent'] );
                }
            }
        }
    }
        
//     function printBadge($goBack)
//     {
//         echo "<a href = \"".$goBack."help.pdf\" target=\"_blank\">";
            
//         echo <<<HTML
            
//         <div style="position : absolute; margin-left : 40px; margin-top : 24px">
//         <div class="badger-outter">
//         <div class="badger-inner">
//             <p class="badger-badge badger-text" id="guida" > ? </p>
//         </div>
//     </div>
//         </div>
//         </a>
// <script>
//     $('guida').badger('?');
// </script>
// HTML;
//     }
        
//    function checkVoto() { //controllo del voto e stampa un messaggio in caso di successo o di errore
//        if (isset ( $_SESSION ['grade_sent'] )) {
//            if ($_SESSION ['grade_sent'] == 2) {
//                echo "<script>alert(\"Il voto è stato inviato con successo.\"); </script>";
//                unset ( $_SESSION ['grade_sent'] );
//            } else {
//                if ($_SESSION ['grade_sent'] == 1) {
//                echo "<script>alert(\"Si è verificato un errore durante la connessione al database.\");</script>";
//                    unset ( $_SESSION ['grade_sent'] );
//                } else {
//                    if ($_SESSION ['grade_sent'] == 3) {
//                echo "<script>alert(\"Si è verificato un errore durante l'invio del voto.\");</script>";
//                        unset ( $_SESSION ['grade_sent'] );
//                    }
//                }
//            }
//        }
//    }    
    
    function footer ($goBack) {
        echo <<<HTML
            <footer>
                <div class="container">
            		<div class="row">
        				<div class="col col-sm-12">
					        <div class="panel">
	            				<div class="col col-sm-6">
        							<a href='http://www.istitutolevi.it/' target='_blank' title='Istituto Primo Levi'>
HTML;
		        						echo "<img id='levi-logo' class='img-rounded' src='".$goBack."src/img/levi_logo.png' alt=''>";
		        					echo <<<HTML
			        				</a>
	        						<p class="levi-text">
	        							Con il patrocinio dell'istituto Primo Levi di Vignola.
	        						</p>
	                            </div>
		            			<div id="footer-contact" class="col col-sm-4 col-sm-offset-2">
	        						<p>
	        							<h4>Contatti:</h4>
		        						<ul>
		        							<li>
        										Daniele Manicardi:
		        								<ul>
		        									<li>
		        										<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
			        									<a href="tel:+39 334 9056026" class="contact-link">+39 334 905 6026</a>
		        									</li>
		        									<li>
		        										<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
		        										<a href="mailto:manicardi215@gmail.com" class="contact-link">manicardi215@gmail.com</a>
		        									</li>
		        								</ul>
        									</li>
		        							<li>
		        								Alessio Scheri:
		        								<ul>
		        									<li>
		        										<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
			        									<a href="tel:+39 333 2810581" class="contact-link">+39 333 281 0581</a>
		        									</li>
		        									<li>
		        										<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
		        										<a href="mailto:alessio.scheri@gmail.com" class="contact-link">alessio.scheri@gmail.com</a>
		        									</li>
		        								</ul>
		        							</li>
		        						</ul>
	        						</p>
		                        </div>
        						<div class="col col-sm-12 final">
		        					<hr>
			        				<div class="row">
			            				<div class="col col-sm-9">
				        					<p id="copyright">
				        						&copy; Copyright
				        					</p>
				        				</div>
			            				<div class="col col-sm-3 text-right">
				        					<a id="privacy-policy">
				        						privacy policy
				        					</a>
				        				</div>
			        				</div>
		        				</div>
	                        </div>
	        			</div>
                    </div>
                </div>
            </footer>
HTML;
    }
    
//     function footer (){
//         echo <<<HTML
//             <footer>
//                 <div class="container">
//             		<div class="row">
//             			<div class="col col-sm-12">
// 				            <div class="panel">
//                                 <p class="text-center">
// Classe 5^B 2014/2015: Scheri Alessio(Gestore Incaricato),Chitoroaga Constantin, Cois Alessio, Corradi Federico, D'Alcamo Kael, Emini Damiano, Kapelyukh Mirko, Liso Emanuele, Mastrangelo Salvatore, Menabue Matteo, Orlandi Mattia, Passuti Roberto, Pevarello Marco, Pizzirani Federico, Rapini Fabio, Sargenti Mattia, Scheri Alessio, Sgarzi Mattia, Singh Rupinder, Vaccari Nicola, Veronesi Matteo, Zambardi Alessio.
// <br> <br> Classe 5^B 2015/2016: Manicardi Daniele(Gestore Incaricato),Borelli Fabio, Cafagna Michele, Calaiò Salvatore, Calzone Davide,Casini Simone, Enache Alexandru, Faedda Veronica, Fedele Davide , Fernando Pasan,Fossali Ludovico,  Leuzzi  Alessio, Maini Fabio, Manicardi Daniele, Manni Filippo, Minelli Andrea , Odorici Paolo, Pedroni Nicolò, Pizzirani Paolo, Ternelli Mirco.
//                                 </p>
//                                 <p class="leviFooter text-center">
//                                     Istituto Primo Levi, Vignola
//                                 </p>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </footer>
// HTML;
//     }
        
    function printChat($goback){
        echo" 
        <div id=\"wholechat\">
            <div id=\"chat\" onclick=\"fillChat('".$_SESSION['nameTable']."', '$goback')\" class=\"chat-container\">
                <p id=\"nascondi\" class=\"hide-show-p\"><a id=\"nascondilink\" href=\"javascript:hideChat()\" class=\"hide-show-link\"> Chat </a></p>
                <div id='chatcontent'>
                </div>
            </div>
        </div>";
    }
    
    function studentNoStageWarning () {
        echo <<<HTML
            <div align="center">
                <h1 class="alert-warning"> Non sei pronto per andare in stage. </h1>
            </div>
HTML;
    }
?>