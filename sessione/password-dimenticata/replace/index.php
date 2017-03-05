<?php
	include "../../../pages/functions.php";
	open_html ( "Ripristino password" );
        import("../../../");
?>
<body>
<?php
    topNavbar ("../../../");
    titleImg ("../../../");
?>
    <script> 
        //alert(typeof(localStorage.authorized_replace_type_user));
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
	close_html ("../../../");
?>