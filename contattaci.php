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
		        							<i class="glyphicon glyphicon-phone" aria-hidden="true"></i>
			        						<a href="tel:<?php echo TELEFONO_DANIELE?>" class="contact-link"><?php echo TELEFONO_DANIELE?></a>
		        						</li>
		        						<li>
		        							<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
		        							<a href="mailto:<?php echo EMAIL_DANIELE?>" class="contact-link"><?php echo EMAIL_DANIELE?></a>
		        						</li>
		        					</ul>
		                    	</div>
		                    	<div class="col col-sm-6">
		                    		<span><strong>Alessio Scheri:</strong></span>
		        					<ul>
		        						<li>
		        							<i class="glyphicon glyphicon-phone" aria-hidden="true"></i>
			        						<a href="tel:<?php echo TELEFONO_ALESSIO?>" class="contact-link"><?php echo TELEFONO_ALESSIO?></a>
		        						</li>
		        						<li>
			        						<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
			        						<a href="mailto:<?php echo EMAIL_ALESSIO?>" class="contact-link"><?php echo EMAIL_ALESSIO?></a>
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
</body>
<?php
	close_html("");
?>