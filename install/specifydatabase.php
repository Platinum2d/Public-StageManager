<html>
    <head>
        <title> Installazione! </title>
        <?php
            include "../pages/functions.php";
            import("../");
        ?>
        <link href="installStyle.css" rel="stylesheet">
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="col col-sm-12">
                    <div class="panel mainpanel" style="min-height: 0px">
                        <h1 style="color:#ff3333"> CREDENZIALI DEL DATABASE </h1> <br> <div id="plis">Abbiamo bisogno di sapere dove verranno memorizzati i tuoi dati. Compila i campi sottostanti per favore.</div> <br>
                        Puoi utilizzare sia un database gia' impostato per il software Alternanza Scuola-Lavoro che vuoto.
                        <br><br>
                            <div class="paddedDiv"> Host <input type="text" class="form-control" id="databasehost"></div> 
                            <div class="paddedDiv"> Database <input type="text" class="form-control" id="database"> </div>
                            <div class="paddedDiv"> Utente <input type="text" class="form-control" id="databaseuser"> </div>
                            <div class="paddedDiv"> Password <input type="password" class="form-control" id="databasepassword"> </div>
                            <div class="paddedDiv" align="left">  <input id="sub" type="button" value="Effettua un test" class="btn btn-primary" onclick="checkDataAndGo()"> 
                                <label style="vertical-align: middle; margin-top: 9px"> <input type="checkbox" id="overwrite" style="margin-left: 20px;">Sovrascrivi il database (tutti i contenuti correnti verranno eliminati)</label> 
                                <br> <input type="button" value="Effettua un test" class="btn btn-primary" disabled="true" style="visibility: hidden"> 
                                <label style="vertical-align: middle; margin-top: 9px"> <input type="checkbox" id="readytouse" style="margin-left: 20px;">Utilizza il database come gia' pronto (non verranno applicate modifiche)</label> 
                                <br> <br> <p id="report">  </p>
                            </div> 
                            <div class="paddedDiv" align="right"> <input class="btn btn-primary" value="Avanti" type="button" onclick="go()" disabled="true"> </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <script>
            $("#readytouse").prop("checked",true);
            
            //$(".paddedDiv").width($("#plis").width());
            database = {
              'host' : '',
              'name' : '',
              'user' : '',
              'password' : '',
              'overwrite' : false,
              'readytouse' : false
            };
            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };
            
            $("#overwrite").change(function (e){
               if ($("#overwrite").prop("checked")) $("#readytouse").prop("checked",false); 
            });
            
            $("#readytouse").change(function (e){
               if ($("#readytouse").prop("checked")) $("#overwrite").prop("checked",false); 
            });
            
            var timer = setInterval(function(){
               if (($("#databasehost").val()).isEmpty() || ($("#database").val()).isEmpty() || ($("#databaseuser").val()).isEmpty()){
                   $("#sub").prop("disabled",true);
               }
               else
               {
                   $("#sub").prop("disabled",false);
               }
               
               
               
               
               
               if ($("#readytouse").prop("checked"))
               {
                   //$("#overwrite").prop("disabled",true);
                   $("#overwrite").prop("checked",false);
                   //$("#overwrite").closest("label").css("color","#CCCCCC");
               }

               
               if ($("#overwrite").prop("checked"))
               {
                  // $("#readytouse").prop("disabled",true);
                   $("#readytouse").prop("checked",false);
                   //$("#readytouse").closest("label").css("color","#CCCCCC");
               }
               
            },1);
            
            
            $("#databasehost").keypress(function (e){ $("input[value=\"Avanti\"]").prop("disabled",true) });
            $("#database").keypress(function (e){ $("input[value=\"Avanti\"]").prop("disabled",true) });
            $("#databaseuser").keypress(function (e){ $("input[value=\"Avanti\"]").prop("disabled",true) });
            $("#databasepassword").keypress(function (e){ $("input[value=\"Avanti\"]").prop("disabled",true) });
            
            function checkDataAndGo(){
                database.host = ''+$("#databasehost").val();
                database.name = ''+$("#database").val();
                database.user = ''+$("#databaseuser").val();
                database.password = ''+$("#databasepassword").val();
                database.readytouse = ($("#readytouse").prop("checked")) ? true : false;
                database.overwrite = ($("#overwrite").prop("checked")) ? true : false;
                
                $("#report").html("Connessione....");
                
                if (database.overwrite)
                {
                    $.ajax({
                        type : 'POST',
                        url : 'ajaxOps/ajaxCheck.php',
                        cache : false,
                        data : database,
                        success : function(msg)
                        {
                            if (msg === "ok")
                            {
                                $("#report").html("Connessione riuscita!");
                                $("#errors").html("");
                                $("#report").css("color","green");
                                $("input[value=\"Avanti\"]").prop("disabled",false)
                                //location.href = "specifyuser.php";
                            }
                            else
                            {
                                $("#report").html("Errore durante la connessione");
                                if (!$("#errors").length)
                                {
                                    $("<p id=\"errors\"> </p>").insertAfter("#report");
                                }
                                $("#errors").html(msg);

                                $("#report").css("color","red");
                            }
                        }
                    })
                }
                else
                {
                   $.ajax({
                       url : "ajaxOps/ajaxKeepDatabase.php",
                       type : "POST",
                       cache : false,
                       data : database,
                       success : function (msg)
                       {
                           if (msg === "ok")
                           {
                                $("#report").html("Connessione riuscita!");
                                $("#errors").html("");
                                $("#report").css("color","green");
                                $("input[value=\"Avanti\"]").prop("disabled",false);
                                $("<input type=\"hidden\" id=\"skipuser\">").insertAfter("#report");
                           }
                           else
                           {
                                $("#report").html("Errore durante la connessione");
                                if (!$("#errors").length)
                                {
                                    $("<p id=\"errors\"> </p>").insertAfter("#report");
                                }
                                $("#errors").html(msg);

                                $("#report").css("color","red");                                
                           }
                       }                   
                   });
                }
            }
            
            function go()
            {
                location.href = ($("#overwrite").prop("checked")) ? "specifyuser.php" : "../pages/done.php";
            }
        </script>
    </body>
</html>