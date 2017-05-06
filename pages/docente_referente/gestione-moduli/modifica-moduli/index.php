<?php
    include '../../../functions.php';
    checkLogin ( docrefType , "../../../../");
    open_html ( "Moduli di valutazione" );
    import("../../../../");
    echo "<link href='css/styles.css' rel='stylesheet' type='text/css'>";
    $conn = dbConnection("../../../../");
        
?>
    
<body>
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
                                    <tr>
                                    	<td class="menu-voice" align="center">
                                    		<h2><a href="moduli_valutazione_studenti/index.php">Moduli di valutazione degli studenti</a></h2>
                                    	</td>
                                	</tr>
                                    <tr>
                                    	<td class="menu-voice" align="center">
                                    		<h2><a href="moduli_valutazione_stage/index.php">Moduli di valutazione delle aziende</a></h2>
                                    	</td>
                                	</tr>
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