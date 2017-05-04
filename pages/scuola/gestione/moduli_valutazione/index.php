<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Moduli di valutazione" );
    import("../../../../");
    $conn = dbConnection("../../../../");
        
?>
    
<body>
    <style>
        a{
            color : #555
        }
    </style>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Moduli di valutazione </h1><br>
                    <div class="row">
                        <div class="col col-sm-12"> 
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="moduli_valutazione_studenti/index.php">Moduli di valutazione degli studenti</a>  </h1> </td> </tr>
                                    <tr> <td align="center"><h1> <a href="moduli_valutazione_stage/index.php">Moduli di valutazione delle aziende</a>  </h1> </td> </tr>
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
    close_html ("../../../../");
?>