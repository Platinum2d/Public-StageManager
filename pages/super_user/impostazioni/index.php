<?php
    include '../../functions.php';
    checkLogin ( superUserType , "../../../");
    open_html ( "Impostazioni" );
    import("../../../");
    $connessione = dbConnection ("../../../");
?>
<body>
    <?php    
        topNavbar ("../../../");
        titleImg ("../../../");          
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div id="mainpanel" class="panel">
                    <h1>Impostazioni</h1><br>
                    <table class="table table-hover">
                        <tr>
                            <td>
                                <div align="center"><h3 ><a style="color: #828282" href="database/index.php"> Modifica database </a></h3></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>