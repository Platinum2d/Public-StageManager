<?php
    include '../../functions.php';
   checkLogin ( scuolaType , "../../../");
    import("../../../");
    open_html ( "Menù - Aziende" );
    $connessione = dbConnection ("../../../");
        
?>
<body>
    <style>
        a{
            color : #555
        }
    </style>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Menù - Aziende </h1><br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="inserimento/index.php">Inserisci aziende</a>  </h1></td> </tr>
                                    <tr> <td align="center"><h1> <a href="visualizzazione/index.php">Visualizza aziende</a> </h1> </td> </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>