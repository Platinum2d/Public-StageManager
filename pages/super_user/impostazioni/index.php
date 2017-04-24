<?php
    include '../../functions.php';
    checkLogin ( superUserType , "../../../");    
    open_html ( "Impostazioni" );
    import("../../../");        
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
                    <h1> Impostazioni </h1><br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="database/index.php">Modifica Database</a>  </h1></td> </tr>
                                    <tr> <td align="center"><h1> <a href="stato/index.php">Modifica stato del portale</a>  </h1></td> </tr>
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