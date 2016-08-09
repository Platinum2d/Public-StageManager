<?php
	include "../../functions.php";
	open_html ( "Password Dimenticata" );
        import("../../../");
?>

<body>
    <?php
    topNavbar ("../../../");
    titleImg ("../../../");
    ?>
    
    <!-- Begin Body -->
    <script> 
        setInterval(function()
        { 
            var email = ""+$("input[name=mail]").val();
            var confermamail = ""+$("input[name=confermamail]").val();
            if (email !== confermamail || !email.trim() || !confermamail.trim()) document.getElementById("send").disabled = true;
            else document.getElementById("send").disabled = false;
        }, 1);
    </script>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <h2 class="form-signin-heading centeredText">RECUPERA LA TUA PASSWORD</h2>
                        <form action="sendmail.php" method="POST">
                            <div class="col col-sm-6">
                                Email per il recupero password <input type="text" class="form-control" name="mail"><br>
                                <input type="submit" class="btn btn-primary" value="Invia" id="send">   
                            </div>
                            
                            <div class="col col-sm-6">
                                Conferma Email <input type="text" class="form-control" name="confermamail">
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