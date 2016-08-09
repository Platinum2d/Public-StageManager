<?php
    include "../../functions.php";
    checkLogin ( ceoType , "../../../");
    open_html ( "Inserisci tutor" );
    import("../../../");
    echo "<script src='../../src/lib/bootstrap-filestyle/bootstrap-filestyle.min.js'></script>";
    echo "<script src='../assegnazione_tutor/js/scripts.js'></script>";
    $conn = dbConnection ("../../../");
    
?>
<link rel="stylesheet" href="stile.css">

<script type="text/javascript">
    $(document).ready(function() {
        $("#studenti_carica").trigger("click");
    }  );
</script>

<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
        $idAzienda = $_SESSION['userId'];
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Assegnazione tutor</h1>
                    <div class="row">
                        <div class="col col-sm-12">
                            <ul id="classes" class="nav nav-tabs">
                                <?php
                                    $query = "SELECT  `nome`, `cognome`, `azienda_id_azienda` FROM  `studente` WHERE `azienda_id_azienda`=$idAzienda" ;                              
                                    $result1 = $conn->query($query);       
                                    $row = $result1->fetch_assoc () ;
                                        $nome = $row ['nome'];
                                        $cognome = $row ['cognome'];
                                        echo  "<li>
                                            
                                                <a id='studenti_carica' class='navbar-brand classe' href='javascript:void(0)'>
                                                   Studenti in carico
                                                </a>
                                            </li>";
                                ?>
                                
                            </ul>
                            <div id="messageSpace">
                                <p id="message" class="bg-success">
                                    Modifica avvenuta con successo.
                                </p>
                            </div>
                            <div id="main">
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