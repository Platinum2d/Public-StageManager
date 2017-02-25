<?php    
    include "../functions.php";
    if (!isset($_SESSION ['type'])){
        header ("Location:../../index.php");
    }
    open_html ( "Valutaci!" );
    import("../../");
    $connessione = dbConnection("../../");
    $result = $connessione->query("SELECT `voto`, `descrizione` 
									FROM `valutazione_applicazione` 
									WHERE `utente_id_utente` = ".$_SESSION['userId'].";");
    echo "<body>";
    if ($result->num_rows === 0)
    {        
    ?>
<script>        
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    }; 

    $(document).ready(function(){
    	$("input[value=\"Invia\"]").prop("disabled",true);
	    $("textarea[placeholder=\"Descrizione\"]").keyup (function () {
	    	if ($("textarea[placeholder=\"Descrizione\"]").val().isEmpty() || $("#overall").val() === '0')
	            $("input[value=\"Invia\"]").prop("disabled",true)
	        else
	            $("input[value=\"Invia\"]").prop("disabled",false)
	    });
    });
//     var timer = setInterval(function (){
//         if ($("textarea[placeholder=\"Descrizione\"]").val().isEmpty() || $("#overall").val() === '0')
//             $("input[value=\"Invia\"]").prop("disabled",true)
//         else
//             $("input[value=\"Invia\"]").prop("disabled",false)
//    },1)
        
    function changeStars(progressiv)
    {
        var I=0;
        for (I=1;I<=progressiv;I++)
        {
            $("#star"+I).attr("src","../../media/img/LightedStar.JPG");
        }
            
        for (I=progressiv+1;I<=5;I++)
        {
            $("#star"+I).attr("src","../../media/img/TurnedDownStar.JPG");
        }
        $("#overall").val(progressiv);
    }
        
    function send(){
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerValutazione/ajaxInvia.php',
            cache : false,
            data : {
                'voto' : $("#overall").val(),
                'descrizione' : $("textarea[placeholder=\"Descrizione\"]").val()
            },
            success : function (msg)
            {
                if (msg === 'ok'){
                    $("#mainpanel").html("<div align=\"center\"> <h1> Grazie! </h1> Il tuo feedback contribuira' allo sviluppo dell'applicazione. </div>");
                }
            }
        })
    }
</script>
   	<?php
        topNavbar ("../../");
        titleImg ("../../");
    ?>
<div class="container">
    <div class="row">
        <div class="col col-sm-12">
            <div class="panel">
                <div id="mainpanel">
                    
                        
                    <h1> Valutaci! </h1><br>
                    La tua opinione è molto importante per noi. Grazie ad essa, riusciremo ad offrirti un gestionale sempre più efficiente.
                    <br><br>
                    <input type="hidden" value="0" id="overall">
                    
                    <div>
                        <img id="star1" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(1)">
                        <img id="star2" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(2)">
                        <img id="star3" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(3)">
                        <img id="star4" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(4)">
                        <img id="star5" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(5)">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-sm-9">
                            <div >
                                <textarea class="form-control" style='margin-left:auto; margin-right:auto; text-align: left;' rows='10' cols='60' placeholder="Descrizione"></textarea>
                            </div>
                        </div>
                    </div> <br>
                    <input type="button" class="btn btn-primary" value="Invia" onclick="send()">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php
    close_html ("../../");
    }
 else 
     {
     $row = $result->fetch_assoc();
     $descrizione = $row['descrizione'];
     $voto = intval($row['voto']);
     ?>
<script>        
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    }; 

    $(document).ready(function(){
	    $("textarea[placeholder=\"Descrizione\"]").keyup (function () {
	    	if ($("textarea[placeholder=\"Descrizione\"]").val().isEmpty() || $("#overall").val() === '0')
	            $("input[value=\"Invia\"]").prop("disabled",true)
	        else
	            $("input[value=\"Invia\"]").prop("disabled",false)
	    });
    });
        
//     var timer = setInterval(function (){
//         if ($("textarea[placeholder=\"Descrizione\"]").val().isEmpty() || $("#overall").val() === '0')
//             $("input[value=\"Invia\"]").prop("disabled",true)
//         else
//             $("input[value=\"Invia\"]").prop("disabled",false)
//     },1)
        
    function changeStars(progressiv)
    {
        var I=0;
        for (I=1;I<=progressiv;I++)
        {
            $("#star"+I).attr("src","../../media/img/LightedStar.JPG");
        }
            
        for (I=progressiv+1;I<=5;I++)
        {
            $("#star"+I).attr("src","../../media/img/TurnedDownStar.JPG");
        }
        $("#overall").val(progressiv);
    }
        
    function send(){
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerValutazione/ajaxUpdate.php',
            cache : false,
            data : {
                'voto' : $("#overall").val(),
                'descrizione' : $("textarea[placeholder=\"Descrizione\"]").val()
            },
            success : function (msg)
            {
                if (msg === 'ok'){
                    $("#mainpanel").fadeOut("fast");                    
                    $("#mainpanel").hide();         
                    $("#mainpanel").html("<div align=\"center\"> <h1> Grazie! </h1> Il tuo feedback contribuira' allo sviluppo dell'applicazione. </div>");
                    $("#mainpanel").fadeIn("slow");                    
                }
            }
        })
    }
</script>
   	<?php
        topNavbar ("../../");
        titleImg ("../../");
        printChat("../../");
    ?>
<div class="container">
    <div class="row">
        <div class="col col-sm-12">
            <div class="panel" >
                <div id='mainpanel'>
                <h1> Valutaci! </h1><br>
                La tua opinione è molto importante per noi. Grazie ad essa, riusciremo ad offrirti un gestionale sempre più efficiente.
                <br><br>
                <div>
                        <?php 
                        echo "<input type=\"hidden\" value=\"$voto\" id=\"overall\">";
                        for ($I=1;$I<=$voto;$I++)
                        {
                            echo "<img id=\"star$I\" src=\"../../media/img/LightedStar.JPG\" onclick=\"changeStars($I)\">";
                        }
                            
                        for ($I=$voto+1;$I<=5;$I++)
                        {
                            echo "<img id=\"star$I\" src=\"../../media/img/TurnedDownStar.JPG\" onclick=\"changeStars($I)\">";
                        }
                            
                        ?>
<!--                        <img id="star1" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(1)">
                    <img id="star2" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(2)">
                    <img id="star3" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(3)">
                    <img id="star4" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(4)">
                    <img id="star5" src="../../media/img/TurnedDownStar.JPG" onclick="changeStars(5)">-->
                </div>
                <br>
                <div class="row">
                    <div class="col col-sm-9">
                        <div >
                            <textarea class="form-control" style='margin-left:auto; margin-right:auto; text-align: left;' rows='10' cols='60' placeholder="Descrizione"><?php echo trim($descrizione); ?></textarea>
                        </div>
                    </div>
                </div> <br>
                <input type="button" class="btn btn-primary" value="Invia" onclick="send()">
                </DIV>
            </div>
        </div>
    </div>
</div>
</body>
<?php
     close_html("../../");
    }
?>