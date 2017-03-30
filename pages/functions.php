<?php
    session_start ();
    
    define ( "superUserType", 0 );
    define ( "scuolaType", 1 ); //contiene il valore corrispondente all'utente super_user
    define ( "docrefType", 2 ); //contiene il valore corrispondente all'utente docente referente
    define ( "doctutType", 3 ); //contiene il valore corrispondente all'utente docente tutor
    define ( "ceoType", 4 ); //contiene il valore corrispondente all'utente ceo
    define ( "aztutType", 5 ); //contiene il valore corrispondente all'utente tutor azienda
    define ( "studType", 6 ); //contiene il valore corrispondente all'utente studente
    
    define ( "err_noLog", 1 ); //contiene il valore relativo all'errore corrispondente all'utente che cerca di accedere ad una pagina senza essersi loggato
    define ( "err_noPerm", 2 ); //contiene il valore relativo all'errore corrispondente all'utente che cerca di accedere ad una pagina per la quale non ha i permessi necessari (pagina per un altro utente)
    
    define ( "sent", 2);  //contiene il valore corrispondente ad un email correttamente inviata
    define ( "notSent", 1);   //contiene il valore corrispondente ad un email non correttamente inviata
    
    define ( "maximumProfileImageSize", 50000); //50 Mb, è la massima dimensione di un'immagine di profilo
    
    define ( "EMAIL_ALESSIO", "alessio.scheri@stagemanager.it" ); //Indirizzo email di Alessio
    define ( "EMAIL_DANIELE", "manicardi@stagemanager.it" ); //Indirizzo email di Daniele
    define ( "TELEFONO_ALESSIO", "+39 333 2810581" ); //Numero di telefono di Alessio
    define ( "TELEFONO_DANIELE", "+39 334 9056026" ); //Numero di telefono di Daniele
    
    /*function resetDBconf($goBack)
    {
        require_once ($goBack + "db_config.php");
        $_SESSION['dbhost'] = $host;
        $_SESSION['dbuser'] = $user;
        $_SESSION['dbpassword'] = $password;
        $_SESSION['dbname'] = $name;
    
        $connessioneforuse = new mysqli($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpassword'],$_SESSION['dbname']);
        $connessioneforuse->query("USE ".$_SESSION['dbname']);
    }*/
    
    function dbConnection($goBack) // connessione al database 'alternanza_scuola_lavoro' come utente root. ritorna un alert con il messaggi od ierrore se la connessione non è riuscita
    {
        require ($goBack . "db_config.php");
        if (!file_exists($goBack."okuser.txt")) {
            header ( "Location: ".$goBack."install/index.php" );
        }
        /*if (!isset($_SESSION['dbhost']) || !isset($_SESSION['dbuser']) || !isset($_SESSION['dbpassword']) || !isset($_SESSION['dbname']))
        {
            resetDBconf($goBack);
        }*/
    
        $connessione = new mysqli($dbhost,$dbuser,$dbpassword,$dbname);
    
        if ($connessione->connect_error)
        {
            require ($goBack . "db_config.php");
            $connessione = new mysqli($dbhost,$dbuser,$dbpassword,$dbname);
            return ($connessione->connect_error) ? $connessione->connect_error : $connessione;
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
        echo "<li><a href='".$goBack."index.php'><i class='glyphicon glyphicon-home'> </i> Home</a></li>";
        if (! isset ( $_SESSION ['type'] )) {
            echo <<<HTML
                        </ul>
HTML;
        } else {
    
            if ($_SESSION ['type'] == superUserType) { // se e' loggato amministratore
                echo "<script> $(\".dropdown-toggle .dropdown .dropdown-hover .open\").click(function (){ location.href = \"".$goBack."pages/super_user/inserimento/index.php\" }) </script>";
                echo " <li><a href='".$goBack."pages/super_user/profiloutente/index.php'>Profilo</a></li>";
                echo "<li class=\"dropdown dropdown-hover\">";
                echo "<a href=\"".$goBack."pages/super_user/inserimento/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Inserimento <span class=\"caret\"></span></a><ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\">";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/anniscolastici/index.php'>Anni Scolastici</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/aziende/index.php'>Aziende</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/classi/index.php'>Classi</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/docenti/index.php'>Docenti</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/figureprofessionali/index.php'>Figure Professionali</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/scuole/index.php'>Scuole</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/settori/index.php'>Settori</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/stage/index.php'>Stage</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/studenti/index.php'>Studenti</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/inserimento/tutor/index.php'>Tutor</a></li>";
                echo "</ul></li>";
                echo "<li class=\"dropdown dropdown-hover\">";
                echo "<a href=\"".$goBack."pages/super_user/visualizza/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Visualizza <span class=\"caret\"></span></a>";
                echo "<ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\">";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/anniscolastici/index.php'>Anni scolastici</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/aziende/index.php'>Aziende</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/classi/index.php'>Classi</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/docenti/index.php'>Docenti</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/figureprofessionali/index.php'>Figure professionali</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/scuole/index.php'>Scuole</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/settori/index.php'>Settori</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/stage/index.php'>Stage</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/visualizza/tutor/index.php'>Tutor</a></li>";
                echo "</ul></li>";
                 
                echo "<li class=\"dropdown dropdown-hover\">";
                echo "<a href=\"".$goBack."pages/super_user/segnalazioni/index.php?ris=0\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Segnalazioni <span class=\"caret\"></span></a>";
                echo "<ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\">";
                echo " <li><a href='".$goBack."pages/super_user/segnalazioni/index.php?ris=0'>Da risolvere</a></li>";
                echo " <li><a href='".$goBack."pages/super_user/segnalazioni/index.php?ris=1'>Risolte</a></li>";
                echo "</ul></li>";
    
                echo "</ul>";
    
            } elseif ($_SESSION ['type'] == docrefType) { // se e' loggato docente referente
                echo "<li><a href='".$goBack."pages/docente_referente/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/docente_referente/gestione-studenti/index.php'>Gestione studenti</a></li>";
    
                echo "<li class=\"dropdown dropdown-hover\">
                          <a href=\"".$goBack."pages/docente_referente/gestione-aziende/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Gestione aziende <span class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";
    
                echo "<li><a href='".$goBack."pages/docente_referente/gestione-aziende/inserisci-aziende/index.php'>Inserisci</a></li>";
                echo "<li><a href='".$goBack."pages/docente_referente/gestione-aziende/modifica-aziende/index.php'>Modifica</a></li>";
                echo "</ul></li>";
                echo "<li><a href='".$goBack."pages/docente_referente/tutorato/index.php'>Tutorato</a></li>";
                echo "<li><a href='".$goBack."pages/docente_referente/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                        </ul>
HTML;
            } elseif ($_SESSION ['type'] == doctutType) { // se è loggato docente tutor
                echo "<li><a href='".$goBack."pages/docente_tutor/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/docente_tutor/gestione_studenti/index.php'>Le mie classi</a></li>";
                echo "<li><a href='".$goBack."pages/docente_tutor/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                        </ul>
HTML;
            } elseif ($_SESSION ['type'] == ceoType) { // se è loggato responsabile impresa
                echo "<li><a href='".$goBack."pages/ceo/profiloutente/index.php'>Profilo</a></li>";
                echo "<li class=\"dropdown dropdown-hover\">
                               <a href=\"".$goBack."pages/ceo/la_mia_azienda/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">La mia azienda <span class=\"caret\"></span></a>
                                        <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";

                echo "<li><a href='".$goBack."pages/ceo/la_mia_azienda/index.php'>Informazioni</a></li>";
                echo "<li><a href='".$goBack."pages/ceo/la_mia_azienda/figure_professionali/index.php'>Figure professionali richieste</a></li>";
                echo "</ul></li>";

                echo "<li class=\"dropdown dropdown-hover\">
                               <a href=\"".$goBack."pages/ceo/operazioni_tutor/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Tutor <span class=\"caret\"></span></a>
                                        <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";

                echo "<li><a href='".$goBack."pages/ceo/operazioni_tutor/assegna_tutor/index.php'>Assegna Tutor</a></li>";
                echo "<li><a href='".$goBack."pages/ceo/operazioni_tutor/inserisci_tutor/index.php'>Inserisci Tutor</a></li>";
                echo "<li><a href='".$goBack."pages/ceo/operazioni_tutor/modifica_tutor/index.php'> Visualizza Tutor </a></li>";
                echo "</ul></li>";
                echo "<li><a href='".$goBack."pages/ceo/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                    </ul>
HTML;
            } elseif ($_SESSION ['type'] == aztutType) { // se è loggato tutor aziendale
                echo "<li><a href='".$goBack."pages/tutor/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/tutor/studenti/index.php'>Studenti</a></li>";
                echo "<li><a href='".$goBack."pages/tutor/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                    </ul>
HTML;
            } elseif ($_SESSION ['type'] == studType) { // se è loggato studente
                echo "<li><a href='".$goBack."pages/studente/profiloutente/index.php'>Profilo</a></li>";
                echo "<li><a href='".$goBack."pages/studente/il_mio_stage/index.php'>Il mio stage</a></li>";
                echo "<li><a href='".$goBack."pages/studente/registro/index.php'>Registro</a></li>";
                echo "<li><a href='".$goBack."pages/studente/voto/index.php'>Voto</a></li>";
                echo "<li><a href='".$goBack."pages/studente/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                </ul>
HTML;
            } elseif ($_SESSION ['type'] == scuolaType) {
                echo "<li><a href='".$goBack."pages/scuola/profiloutente/index.php'>Profilo</a></li>";

                echo "<li class=\"dropdown dropdown-hover\">
                  <a href=\"".$goBack."pages/scuola/inserimento/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Inserisci <span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";

                echo "<li><a href='".$goBack."pages/scuola/inserimento/aziende/index.php'>Aziende</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/inserimento/classi/index.php'>Classi</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/inserimento/docenti/index.php'>Docenti</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/inserimento/periodi_stage/index.php'>Periodi di stage</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/inserimento/studenti/index.php'>Studenti</a></li>";
                echo "</ul></li>";

                echo "<li class=\"dropdown dropdown-hover\">
                  <a href=\"".$goBack."pages/scuola/modifica/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Modifica <span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";

                echo "<li><a href='".$goBack."pages/scuola/modifica/aziende/index.php'>Aziende</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/modifica/classi/index.php'>Classi</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/modifica/docenti/index.php'>Docenti</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/modifica/periodi_stage/index.php'>Periodi di stage</a></li>";
                echo "</ul></li>";

                echo "<li class=\"dropdown dropdown-hover\">
                  <a href=\"".$goBack."pages/scuola/gestione/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Gestisci <span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";
                
                echo "<li><a href='".$goBack."pages/scuola/gestione/classi_docenti_referenti/index.php'>Docenti referenti associati alle classi</a></li>";
                echo "<li><a href='".$goBack."pages/scuola/gestione/insegnanti/index.php'>Insegnanti</a></li>";
                echo "</ul></li>";
                echo "<li><a href='".$goBack."pages/scuola/contatta/index.php'>Contatta</a></li>";
                echo <<<HTML
                    </ul>
HTML;
//             } elseif ($_SESSION ['type'] == scuolaType) {
//                 echo "<li><a href='".$goBack."pages/scuola/profiloutente/index.php'>Profilo</a></li>";
                
//                 echo "<li class=\"dropdown dropdown-hover\">
//                       <a href=\"".$goBack."pages/scuola/inserimento/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\"> Inserisci <span class=\"caret\"></span></a>
//                             <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";
                
//                 echo "<li><a href='".$goBack."pages/scuola/inserimento/aziende/index.php'>Aziende</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/inserimento/classi/index.php'>Classi</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/inserimento/docenti/index.php'>Docenti</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/inserimento/periodi_stage/index.php'>Periodi di stage</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/inserimento/studenti/index.php'>Studenti</a></li>";
//                 echo "</ul></li>";
                
//                 echo "<li class=\"dropdown dropdown-hover\">
//                       <a href=\"".$goBack."pages/scuola/modifica/index.php\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\"> Modifica <span class=\"caret\"></span></a>
//                             <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";
                
//                 echo "<li><a href='".$goBack."pages/scuola/modifica/aziende/index.php'>Aziende</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/modifica/classi/index.php'>Classi</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/modifica/docenti/index.php'>Docenti</a></li>";
//                 echo "<li><a href='".$goBack."pages/scuola/modifica/periodi_stage/index.php'>Periodi di stage</a></li>";
//                 echo "</ul></li>";                
                
//                 echo "<li class=\"dropdown dropdown-hover\">
//                       <a href=\"\" class=\"dropdown-toggle disabled\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Gestisci<span class=\"caret\"></span></a>
//                             <ul class=\"dropdown-menu dropdown-menu-hover\" role=\"menu\"> ";
//                 echo "<li><a href='".$goBack."pages/scuola/gestione/classi_docenti_referenti/index.php'>Docenti referenti associati alle classi</a></li>";
//                 echo "</ul></li>";
//                 echo <<<HTML
//                     </ul>      
// HTML;
            }
        }
    }
    
    function loginButton($goBack) { // conferma delle credenziali per il login
        if (isset ( $_SESSION ['user'] ))
        {
            echo <<<HTML
                    <li class="button">
HTML;
            echo "<a href='" . $goBack . "sessione/logout/destroyer.php'><i class='glyphicon glyphicon-user'></i> Logout</a>";
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
    //         echo "<img src='".$goBack."media/img/logo_stage_manager.png' alt='Stage Manager'></a>";
    //         echo <<<HTML
    //               </div>
    //               </div>
    // HTML;
    }
    
    function immagineHeader($goBack) { // inserisce l'immagine di header del sito
        echo <<<HTML
             <div class="col col-sm-12">
HTML;
        echo "<img class='img-responsive' src='".$goBack."media/img/copertina_stage_azzurro.png' alt=''' width='100%' height='326' />";
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
                echo "<a href=\"".$goBack."contattaci.php\" ><i class=\"glyphicon glyphicon-earphone\"> </i> Contattaci </a>";
                if (isset($_SESSION ['type']))
                    echo "<li class=\"button\"> <a href=\"".$goBack."segnala-problema/index.php\"><i class=\"glyphicon glyphicon-exclamation-sign\"> </i> Segnala un problema </a> </li>";
            }
            else
            {
                echo "<li class=\"button\"> <a href=\"".$goBack."pages/super_user/impostazioni/index.php\"><i class=\"glyphicon glyphicon-cog\"> </i> Impostazioni </a></li>";
            }
        }
    
        echo "</li>";
        //echo "<li class=\"button\"> <a href=\"".$goBack."manuale.pdf\"><i class=\"glyphicon glyphicon-book\"> </i> Manuale </a></li>";
        loginButton ($goBack);
        echo"</li></ul>";
    }
    
    function topNavbar($goBack) {  // barra di navigazione che contiene sia la barra orizzontale che i bottoni
//      printBadge($goBack);
        if (!file_exists($goBack."okuser.txt")) {
            header ( "Location: ".$goBack."install/index.php" );
        }
    
        echo "<div class='container'><div id='logo-row' class='row parent-max-height'><div class='col col-xs-4 col-sm-3'><a href='".$goBack."' title='Stage Manager'><img class='logo img-responsive' src='".$goBack."media/img/logo_stage_manager.png' alt='Stage Manager'></a></div>"; //menù giusto
        echo "<div id='title' class='col col-xs-8 col-sm-9 child-max-height'><h1>Stage Manager</h1></div></div></div>";
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
    immagineHeader ($goBack);
    
    echo <<<HTML
                </div>
              </div>    <!--header-->
    
            </header>
HTML;
    
    printMainModel();
    }
    
    function import($goBack) { //importa librerie
        echo "<link href='".$goBack."lib/bootstrap-3.3.6-dist/css/bootstrap.min.css' rel='stylesheet'>";
        echo "<link href='".$goBack."lib/bootstrap-3.3.6-dist/css/bootstrap-theme.min.css' rel='stylesheet'>";
        echo "<script src=\"".$goBack."pages/scripts.js\"> </script>";
        echo "<script src='".$goBack."lib/jQuery/jquery-2.2.3.min.js'></script>";
        echo "<script src='".$goBack."lib/bootstrap-3.3.6-dist/js/bootstrap.min.js'></script>";
        echo "<script src='".$goBack."lib/bootstrap-filestyle/bootstrap-filestyle.min.js'></script>";
        echo "<link href='".$goBack."lib/custom/css/styles.css' rel='stylesheet'>";
        echo "<script src='".$goBack."lib/jquery-ui-1.11.4/jquery-ui.min.js'></script>";
        echo "<link href='".$goBack."lib/jquery-ui-1.11.4/jquery-ui.min.css' type'text/css' rel='stylesheet'>";
        echo "<link href='".$goBack."lib/custom/css/custom.css' rel='stylesheet'>";
        echo "<link href='".$goBack."lib/badger/badger.css' rel='stylesheet'>";
        echo "<script src='".$goBack."lib/custom/js/scripts.js'></script>";
        echo "<script src='".$goBack."lib/badger/badger.js'></script>";
        echo "<link rel='icon' type='image/png' href='".$goBack."media/img/favicon.png'>";
        echo "<link href='".$goBack."lib/bootstrap-select-1.10.0/dist/css/bootstrap-select.min.css' rel='stylesheet'>";
        echo "<script src='".$goBack."lib/bootstrap-select-1.10.0/dist/js/bootstrap-select.js'></script>";
        echo "<script src='".$goBack."lib/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.js'></script>";
        echo "<link href='".$goBack."lib/bootstrap-tagsinput-latest/dist/bootstrap-tagsinput.css' rel='stylesheet'>";
        echo "<script src='".$goBack."lib/bootstrap-fileinput/js/fileinput.js'></script>";
        echo "<link href='".$goBack."lib/bootstrap-fileinput/css/fileinput.css' rel='stylesheet'>";
        echo "<script src='".$goBack."lib/jsPDF-1.3.3/dist/jspdf.debug.js'></script>";
        echo "<script src='".$goBack."lib/jsPDF-AutoTable-2.3.1/dist/jspdf.plugin.autotable.js'></script>";
        echo "<script src='https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js'></script>";
        echo "<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>";
    }
    
    function open_html($title) { // apre la pagina con il relativo titolo
    
        echo "<!DOCTYPE html>";
    echo <<<HTML
        
                <html lang="it">
                        <head>
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1">
    
                                <title>$title</title>
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
                    <script>alert("Si prega di effettuare il login");
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
        $anno_attuale = date("Y");
        echo <<<HTML
                <footer>
                    <div class="container">
                		<div class="row">
            				<div class="col col-sm-12">
    					        <div class="panel">
    	            				<div class="col col-sm-6">
            							<a href='http://www.istitutolevi.it/' target='_blank' title='Istituto Primo Levi'>
HTML;
        echo "<img id='levi-logo' class='img-rounded' src='".$goBack."media/img/levi_logo.png' alt=''>";
        echo <<<HTML
    			        				</a>
    	        						<p class="levi-text">
    	        							<i>Con il patrocinio dell'istituto Primo Levi di Vignola.</i>
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
    		        										<i class="glyphicon glyphicon-phone" aria-hidden="true"></i>
HTML;
        echo "<a href='tel:".TELEFONO_DANIELE."' class='contact-link'> ".TELEFONO_DANIELE."</a>";
        echo <<<HTML
    		        									</li>
    		        									<li>
    		        										<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
HTML;
        echo "<a href='mailto:".EMAIL_DANIELE."' class='contact-link'> ".EMAIL_DANIELE."</a>";
        echo <<<HTML
    		        									</li>
    		        								</ul>
            									</li>
    		        							<li>
    		        								Alessio Scheri:
    		        								<ul>
    		        									<li>
    		        										<i class="glyphicon glyphicon-phone" aria-hidden="true"></i>
HTML;
        echo "<a href='tel:".TELEFONO_ALESSIO."' class='contact-link'> ".TELEFONO_ALESSIO."</a>";
        echo <<<HTML
    		        									</li>
    		        									<li>
    		        										<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
HTML;
        echo "<a href='mailto:".EMAIL_ALESSIO."' class='contact-link'> ".EMAIL_ALESSIO."</a>";
        echo <<<HTML
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
    				        						Stage Manager  &copy; $anno_attuale
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
    
    function studentNoStageWarning () {
        echo <<<HTML
                <div align="center">
                    <h1 class="alert-warning"> Non sei pronto per andare in stage. </h1>
                </div>
HTML;
    }
    
    function printMainModel(){
        echo <<<HTML
            <div id="SuperAlert" class="modal fade" role="dialog">
              <div class="modal-dialog">
    
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                  </div>
                  <div class="modal-body">
    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                  </div>
                </div>
    
              </div>
            </div>
HTML;
    }
    
    function printProfileImageSection($connessione)
    {
        $query = "SELECT immagine_profilo_id_immagine_profilo AS profile FROM utente WHERE id_utente = ".$_SESSION['userId'];
        $result = $connessione->query($query);
        $row = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
        if (!isset($row['profile']) || $row['profile'] === "-1")
        {
            echo <<<HTML
    
                                <form onsubmit = "return checkSubmitForProfileImage()" class="text-center" action="ajaxOps/avatar_uploader.php" method="post" enctype="multipart/form-data">
                                    <div class="kv-avatar center-block" style="width:200px">
                                        <input id="profileimage" name="profileimage" type="file" class="file-loading">
                                    </div>
                                </form>
HTML;
            ?>
            <script>                                
                $("#profileimage").fileinput({
                    maxFileSize: <?php echo maximumProfileImageSize; ?>,
                    showClose: true,
                    showCaption: false,
                    showBrowse: false,
                    browseOnZoneClick: true,
                    removeLabel: 'Cancella',
                    uploadLabel: "Carica",
                    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                    msgErrorClass: 'alert alert-block alert-danger',
                    defaultPreviewContent: '<img src="../../../media/img/default_avatar_male.jpg" alt="La tua immagine" style="width:160px"><h6 class="text-muted">Clicca per selezionare</h6>',
                    allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                });
            </script>
    
            <?php
    
            }
            else
            {
                $query = "SELECT id_immagine_profilo, URL FROM utente, immagine_profilo WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo AND id_utente = ".$_SESSION['userId'];
                $result = $connessione->query($query);
                $row = $result->fetch_assoc();
                echo "<div align=\"center\"><img style=\"max-height : 255px; max-width : 255px\" id=\"profileimage\" src=\"../../../media/loads/profimgs/".$row['URL']."\"></div><br>";
                echo "<a style=\"color: #828282\"> <span id=\"editspan\" style=\"position:absolute; font-size: 15px; cursor : pointer;\" class=\"glyphicon glyphicon-pencil\"></span></a>";
            ?>
            <script>
                $("#editspan").on("click", function (){
                    $("#SuperAlert").modal("show");
                    var modal = $("#SuperAlert").find(".modal-body");
    
                    $("#SuperAlert").find(".modal-title").html("Cambia l'immagine del profilo");
                    modal.html('<form class="text-center" action="ajaxOps/replace_avatar.php" method="post" enctype="multipart/form-data">\n\
                                    <label class="control-label">Seleziona un\'immagine</label>\n\
                                    <input id="input-file" name = "profileimagechange" type="file" accept="image/*" class="file-loading">\n\
                                </form>');
                                            $("#input-file").fileinput({   
                                                maxFileSize: <?php echo maximumProfileImageSize; ?>,
                                                previewFileType: "image",
                                                browseClass: "btn btn-success",
                                                browseLabel: "Sfoglia...",
                                                browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
                                                removeClass: "btn btn-danger",
                                                removeLabel: "Cancella",
                                                removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
                                                uploadClass: "btn btn-info",
                                                uploadLabel: "Carica",
                                                uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",                                        
                                                allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                                            });
                                            $(".btn-primary > .hidden-xs").html("Seleziona...");
                                            modal.append("<br> <a> Oppure <a href=\"javascript:resetAvatar()\"> <u>ripristina l'avatar predefinito</u></a> </a>");/*
                                            <?php //$urlattuale = $connessione->query("SELECT id_immagine_profilo, URL FROM utente, immagine_profilo WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo AND id_utente = ".$_SESSION['userId'])->fetch_assoc()['URL']; ?>
                                            var maxwidth = $("#SuperAlert").width(), maxheight = $("#SuperAlert").height();
                                            modal.append("<img width=\""+maxwidth+"\" height=\""+maxheight+"\" src=\"../../../media/loads/profimgs/<?php //echo $urlattuale ?> \">");*/
                                        });
    
            </script>
            <?php
            }
    }
    
    function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>
