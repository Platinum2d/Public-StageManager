<?php
	include "../../../functions.php";
	open_html ( "Ripristino Password" );
        import("../../../../");
        $type = $_GET['type'] + 0;
        $id = $_GET['id'];
        switch ($type)
        {
            case 1:
                $tabella = "docente";
                
            break;
                
            case 2:
                $tabella = "studente";        
            break;
                
            case 3:
                $tabella = "tutor";        
            break;
                
            case 4:
                $tabella = "azienda";        
            break;
        }
            
?>

<body>
    <?php
    topNavbar ("../../../../");
    titleImg ();
    ?>
    
    <!-- Begin Body -->
    <script> 
        setInterval(function()
        { 
            var email = ""+$("input[name=password]").val();
            var confermamail = ""+$("input[name=confermapassword]").val();
            if (email !== confermamail || !email.trim() || !confermamail.trim()) document.getElementById("send").disabled = true;
            else document.getElementById("send").disabled = false;
        }, 1);
    </script>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <h2 class="form-signin-heading centeredText">REIMPOSTA LA TUA PASSWORD</h2>
                        <form action="replacepassword.php" method="POST">    
                            <div class="col col-sm-6">
                                Nuova Password <input type="password" class="form-control" name="password"><br>
                                <input type="submit" class="btn btn-primary" value="Invia" id="send">  
                                <?php 
                                        echo "<input type=\"hidden\" value=\"$tabella\" name=\"tabella\">";
                                        echo "<input type=\"hidden\" value=\"$id\" name=\"userid\">";
                                ?>
                            </div>
                                
                            <div class="col col-sm-6">
                                Conferma Nuova Password <input type="password" class="form-control" name="confermapassword">
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
	close_html ();
?>