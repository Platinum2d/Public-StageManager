function redirect(progressiv, idvalstud, idvalaz){
    var selectedValue = $("#select"+progressiv+" option:selected").val();
    $("#select"+progressiv).prop('selectedIndex', 0);
    
    if (selectedValue === "registro")
    {
        $("#registro"+progressiv).submit();
    }
    else
    {
        if (selectedValue === "valutazionestudente" && !$("#view"+progressiv).length)
        {
            if (idvalstud === -1)
            {
                var closestrow = $("#"+progressiv);
                $("<tr id=\"view"+progressiv+"\"> <td colspan=\"5\"> <h3>Questo studente non ha ancora rilasciato una valutazione.</h3>\n\
                     <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\"  onclick=\"closeView("+progressiv+")\"> <span class=\"glyphicon glyphicon-remove\"> \n\
                        </span> </button> </td> </tr>").insertAfter(closestrow);
                $("#view"+progressiv).hide();
                $("#view"+progressiv).fadeIn("slow");
            }
            else
            {
                $.ajax({
                    method : 'POST',
                    url : 'ajaxOps/ajaxGetValutazioneStage.php',
                    cache : false,
                    data : { 'id' :  idvalstud},
                    success : function (xml)
                    {
                        var voto = $(xml).find("valutazione").find("voto").text();
                        var descrizione = $(xml).find("valutazione").find("descrizione").text();
                        var closestrow = $("#"+progressiv);
                        var gradestyle = (voto >=6 ) ? "style=\"color:green\"" : "style=\"color:red\"";
                        
                        $("<tr id=\"view"+progressiv+"\"> <td colspan=\"5\"> \n\
                         <div class=\"row\"> \n\
                            <div class=\"col-sm-12\"> \n\
                              <div class=\"row\">\n\
                                 <div class=\"col-sm-4\">\n\
                                      <h3>Voto Emesso : <span "+gradestyle+">"+voto+" </span> </h3> \n\
                                 </div> \n\
                                 <div class=\"col-sm-8\">\n\
                                      <h3>Commento:</h3> <div style=\"text-align : justify\">"+descrizione+"</div> \n\
                                 </div>      \n\
                              </div>\n\
                            </div> \n\
                        </div> \n\
                        <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\"  onclick=\"closeView("+progressiv+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> </td> </tr>").insertAfter(closestrow);
                        $("#view"+progressiv).hide();
                        $("#view"+progressiv).fadeIn("slow");
                    }
                });
            }
        }
        else
        {
            if (selectedValue === "valutazioneazienda" && !$("#azview"+progressiv).length)
            {
                if (idvalaz === -1)
                {
                    var closestrow = $("#"+progressiv);
                    $("<tr id=\"azview"+progressiv+"\"> <td colspan=\"5\"> <h3>Questo studente non ha ancora ricevuto una valutazione.</h3>\n\
                     <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\"  onclick=\"closeAzView("+progressiv+")\"> <span class=\"glyphicon glyphicon-remove\"> \n\
                        </span> </button> </td> </tr>").insertAfter(closestrow);
                    $("#azview"+progressiv).hide();
                    $("#azview"+progressiv).fadeIn("slow");
                }
                else
                {
                    
                    $.ajax({
                        method : 'POST',
                        url : 'ajaxOps/ajaxGetValutazioneStudente.php',
                        cache : false,
                        data : { 'id' :  idvalaz},
                        success : function (xml)
                        {
                            var gestioneambiente = $(xml).find("valutazione").find("gestione_ambiente_spazio_lavoro").text();
                            var collaborazione = $(xml).find("valutazione").find("collaborazione_comunicazione").text();
                            var usostrumenti = $(xml).find("valutazione").find("uso_strumenti").text();
                            var rispettanorme = $(xml).find("valutazione").find("rispetta_norme_vigenti").text();
                            var rispettaambiente = $(xml).find("valutazione").find("rispetto_ambiente").text();
                            var puntualita = $(xml).find("valutazione").find("puntualita").text();
                            var collaborazionetutor = $(xml).find("valutazione").find("collaborazione_tutor").text();
                            var requisitilavoro = $(xml).find("valutazione").find("lavoro_requisiti").text();
                            var conoscenzetecniche = $(xml).find("valutazione").find("conoscenze_tecniche").text();
                            var acquisireconoscenze = $(xml).find("valutazione").find("acquisire_nuove_conoscenze").text();
                            
                            var closestrow = $("#"+progressiv);
                            $("<tr id=\"azview"+progressiv+"\"> <td colspan=\"5\"> <div class=\"row\"> \n\
                            <div class=\"col-sm-12\"> \n\
                              <div class=\"row\">\n\
                                 <div class=\"col-sm-5\">\n\
                                      <h4> Gestione dell'ambiente di lavoro: "+gestioneambiente+"</h4> \n\
                                      <h4> Collaborazione e comunicazione con lo staff: "+collaborazione+"</h4> \n\
                                      <h4> Utilizzo degli strumenti di lavoro: "+usostrumenti+"</h4>\n\
                                      <h4> Rispetto delle norme vigenti: "+rispettanorme+"</h4>\n\
                                      <h4> Rispetto dell'ambiente di lavoro: "+rispettaambiente+"</h4>\n\
                                 </div> \n\
                                 <div class=\"col-sm-5\">\n\
                                      <h4> Puntualita sul posto di lavoro: "+puntualita+"</h4> \n\
                                      <h4> Collaborazione con il tutor aziendale: "+collaborazionetutor+"</h4> \n\
                                      <h4> Possiede i requisiti lavorativi richesti: "+requisitilavoro+"</h4>\n\
                                      <h4> Possiede i requisiti tecnici richesti: "+conoscenzetecniche+"</h4>\n\
                                      <h4> Ha la capacita' di acquisire nuove conoscenze: "+acquisireconoscenze+"</h4>\n\
                                 </div>      \n\
                              </div>\n\
                            </div> \n\
                            </div> <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\"  onclick=\"closeAzView("+progressiv+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> </td> </tr>").insertAfter(closestrow);
                            $("#azview"+progressiv).hide();
                            $("#azview"+progressiv).fadeIn("slow");
                        }
                    });
                }
            }
        }
    }
}

function closeView(progressiv){
    $("#view"+progressiv).remove();
}

function closeAzView(progressiv){
    $("#azview"+progressiv).remove();
}
