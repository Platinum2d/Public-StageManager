<?php
    include '../functions.php';
   checkLogin ( ceoType , "../../");
    import("../../");
    open_html ( "Tutor" );
    $connessione = dbConnection ("../../");
        
?>
<body>
    <style>
        a{
            color : #555
        }
    </style>
    <?php
        topNavbar ("../../");
        titleImg ("../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Operazioni sui tutor </h1><br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="modifica_tutor/index.php">Modifica tutor</a>  </h1></td> </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col col-sm-6">
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="inserisci_tutor/index.php">Inserisci tutor</a>  </h1></td> </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col col-sm-12">
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="assegna_tutor/index.php">Assegna tutor</a> </h1> </td> </tr>
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
    close_html ("../../");
?>