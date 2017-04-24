<?php
    include "../../pages/functions.php";
    open_html("Sito in manutenzione");
    import("../../");
?>
<body>
    <?php
        topNavbar("../../");    
        titleImg("../../");
    ?>
    <div class="container">
        <div class="panel">
            <div class="row">                
                <div align="center" class="col col-sm-2">
                </div>
                <div align="center" class="col col-sm-8">                    
                    <h1>SITO OFFLINE PER MANUTENZIONE</h1><br>
                    <p>Ci scusiamo per eventuali disagi.</p>
                </div>
            </div>
            <div class="col col-sm-2">
                
            </div>
        </div>
    </div>
</body>
<?php
	close_html("../../");
?>
