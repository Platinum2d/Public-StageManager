<?php
    include '../../../functions.php';
    require ("../../../../sessione/stato-portale/status_config.php");
    checkLogin ( superUserType , "../../../../");    
    open_html ( "Stato del portale" );
    import("../../../../");        
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
                    <h1>Stato del portale</h1><br>                    
                    <div align="center">
                        <h1 style="cursor: pointer" onclick="$('#statusForm').submit()"> Manda il sito 
                        <?php 
                            if ($status) echo "offline"; else echo "online";
                        ?>
                        </h1>
                    </div>
                    <form id="statusForm" method="POST" action="alter_status.php"> 
                        <input name="status" type="hidden" value="<?php if ($status) echo "false"; else echo "true"; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>