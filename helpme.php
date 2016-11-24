<?php
    include "pages/functions.php";
    checkAccessDenied();
    open_html("Contattaci");
    import("");
?>
    
<body>
    
    <?php
        topNavbar("");    
        titleImg("");     
        if (isset($_SESSION['user']))  
        printChat("");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Contattaci</h1>
                    <br>
                    <div class="row">
                        <div id="contact" class="col col-sm-12">
		                    <p>
		                    	Hai bisogno di aiuto? Ecco come contattarci:
		                    </p>
		                    <div class="row">
		                    	<div class="col col-sm-6">
		                    		<span><strong>Daniele Manicardi:</strong></span>
		        					<ul>
		        						<li>
		        							<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
			        						<a href="tel:+39 334 9056026" class="contact-link">+39 334 905 6026</a>
		        						</li>
		        						<li>
		        							<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
		        							<a href="mailto:manicardi215@gmail.com" class="contact-link">manicardi215@gmail.com</a>
		        						</li>
		        					</ul>
		                    	</div>
		                    	<div class="col col-sm-6">
		                    		<span><strong>Alessio Scheri:</strong></span>
		        					<ul>
		        						<li>
		        							<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
			        						<a href="tel:+39 333 2810581" class="contact-link">+39 333 281 0581</a>
		        						</li>
		        						<li>
			        						<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
			        						<a href="mailto:alessio.scheri@gmail.com" class="contact-link">alessio.scheri@gmail.com</a>
		        						</li>
		        					</ul>
		                    	</div>
		                    </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div>
</div>-->
</body>
<?php
	close_html("");
?>