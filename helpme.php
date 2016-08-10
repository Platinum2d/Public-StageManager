<?php
    include "pages/functions.php";
    checkAccessDenied();
    open_html("helpme");
    import("");
?>
    
<body>
    
    <?php
        topNavbar(""); //commento per testare netbeans
        titleImg("");     
        printChat("");
    ?>
        
    <!-- Begin Body -->
    <!--<div class="container">
            <div class="row">
         <div class="col col-sm-3">
            <div id="sidebar">
                <ul class="nav nav-stacked">
                    <li><h3 class="highlight">Channels <i class="glyphicon glyphicon-dashboard pull-right"></i></h3></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                Accordion
                            </a>
                        </div>
                        <div id="collapseOne" class="accordion-body collapse in">
                            <div class="accordion-inner">
                              <p>There is a lot to be said about RWD.</p>
                            </div>
                        </div>
                            </div>
                    <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                    Accordion
                                </a>
                            </div>
                            <div id="collapseTwo" class="accordion-body collapse">
                                <div class="accordion-inner">
                                  <p>Use @media queries or utility classes to customize responsiveness.</p>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div> -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Bisogno di aiuto? Chiama il 334-9056026</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- </div>
</div>-->
</body>
<?php
close_html();
?>