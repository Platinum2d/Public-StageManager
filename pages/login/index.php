<?php
	include "../functions.php";
	open_html ( "Home" );
        import("../../");
	echo "<script src='../../pages/login/login.js'></script>";
?>
    
<body>
    <?php
    topNavbar ("../../");
    titleImg ("../../");
    ?>
        
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="container">
                        <div class="row">
                            <h2 class="form-signin-heading centeredText">SIGN IN</h2>
                            <div id="login" class="col col-sm-offset-2 col-sm-4 vcenter">
                                <form onsubmit="check_login(); return false;">
                                    <br>
                                    <label for="username" class="sr-only">Username</label>
                                    <input id="username" type="text" class="form-control" placeholder="Username" required>
                                    <br>
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="password" type="password"class="form-control" placeholder="Password" required>
                                    <br>
                                    <button id="loginButton" class="btn btn-lg btn-primary btn-block" type="submit">Log in</button> <br>
                                    <div id="forgottenPassword">  
                                        <a href="forgottenpassword/index.php" style="color:#337ab7"> Ho dimenticato la mia password </a>
                                    </div>
                                </form>
                            </div>
                            <div id="login-text" class="col col-sm-4 vcenter">
                                &Egrave; necessario autenticarsi per poter accedere alle funzionalit&agrave; messe a disposizione da questa applicazione web. <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
	close_html ("../../");
?>