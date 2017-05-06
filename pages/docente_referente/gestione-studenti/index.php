<?php
    include '../../functions.php';
    checkLogin ( docrefType , "../../../");
    import("../../../");
    echo "<link href='css/styles.css' rel='stylesheet' type='text/css'>";
    open_html ( "Gestione studenti" );
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
                <div class="panel">
                    <h1> Menù di gestione degli studenti </h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12"> 
                            <div align="center">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="menu-voice" align="center">
                                        	<h2>
                                        		<a href="inserimento/index.php">
                                        			<span>Inserimento</span>
                                        		</a>
                                    		</h2>
                                		</td>
                            		</tr>
                                    <tr>
                                        <td  class="menu-voice" align="center">
                                        	<h2>
                                        		<a href="assegnazione/index.php">
                                        			<span>Assegnazione</span>
                                        		</a>
                                    		</h2>
                                		</td>
                            		</tr>
                                    <tr>
                                        <td  class="menu-voice" align="center">
                                        	<h2>
                                        		<a href="tutorato/index.php">
                                        			<span>Tutorato</span>
                                        		</a>
                                    		</h2>
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
    close_html ("../../../");
?>