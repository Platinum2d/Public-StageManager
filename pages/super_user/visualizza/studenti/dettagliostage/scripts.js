function openInfo(numberId, id_classe_has_stage, id_studente, id_studente_has_stage)
{
    var progressiv = numberId + 1;
    $("<tr> \n\
            <td id=\"editinfo"+progressiv+"\" colspan=\"2\"><div class=\"row\">\n\
                 <div class=\"col col-sm-12\"> \n\
                    <div class=\"row\"> \n\
                       <div class=\"col col-sm-6\"> \n\
                             <label class='custlabel'>Azienda</label><select class=\"form-control\" id=\"editinfoazienda"+progressiv+"\"><option value=\"-1\"> </option> </select>\n\
                             <label class='custlabel'>Tutor</label><select class=\"form-control\" id=\"editinfotutor"+progressiv+"\"><option value=\"-1\"> </option> </select>\n\
                             <label class='custlabel'>Docente</label><select class=\"form-control\" id=\"editinfodocente"+progressiv+"\"><option value=\"-1\"> </option> </select>\n\
                       </div> <br>\n\
                       <div class=\"col col-sm-6\"> \n\
                            <div class=\"list-group\">\n\
                                <a id=\"editvalutazioneazienda"+progressiv+"\" class=\"list-group-item\">Valutazione dello stage</a>\n\
                                <a id=\"editvalutazionestudente"+progressiv+"\" class=\"list-group-item\">Valutazione dello studente</a>\n\
                            </div>\n\
                            \n\
                            <div class=\"checkbox\">\n\
                              <label class='custlabel'><input id=\"editinfovisita"+progressiv+"\" type=\"checkbox\">Azienda visitata</label>\n\
                            </div>\n\
                            <div class=\"checkbox\">\n\
                              <label class='custlabel'><input id=\"editinfoautorizzazione"+progressiv+"\" type=\"checkbox\">Autorizzazione alla compilazione del registro</label>\n\
                            </div>\n\
                            <button id=\"confirm"+progressiv+"\" class=\"btn btn-success btn-sm rightAlignment margin buttonfix\" onclick=\"\">\n\
                                <span class=\"glyphicon glyphicon-ok\"></span>\n\
                            </button>\n\
                            <button id=\"closedit"+progressiv+"\" class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+progressiv+")\">\n\
                                <span class=\"glyphicon glyphicon-remove\"></span>\n\
                            </button>\n\
                        </div> \n\
                    </div> \n\
                 </div>\n\
            </div></td> <td></td> </tr>").insertAfter("#riga"+numberId);
    
    $("#editinfo"+progressiv).hide();
    $("#editinfo"+progressiv).fadeIn();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDettaglioStage/getData.php',
        data : { 'studente' : id_studente, 'classe_stage' : id_classe_has_stage, 'studente_has_stage' : id_studente_has_stage },
        cache : false,
        success : function (xml){
            var authorised = $(xml).find("autorizzazione").text();
            var visited = $(xml).find("visitata").text();
            var studente_has_stage = id_studente_has_stage;
            
            $("#confirm"+progressiv).attr('onclick',"sendData("+progressiv+", "+id_classe_has_stage+", "+id_studente+", "+studente_has_stage+")");
            
            if (visited === "1")
                $("#editinfovisita"+progressiv).prop("checked", true);
            else
                $("#editinfovisita"+progressiv).prop("checked", false);
            
            if (authorised === "1")
                $("#editinfoautorizzazione"+progressiv).prop("checked", true);
            else
                $("#editinfoautorizzazione"+progressiv).prop("checked", false);
            
            if ($(xml).find("valutazione_stage").text() === "-1") 
                $("#editvalutazioneazienda"+progressiv).addClass("disabled");
            else
                $("#editvalutazioneazienda"+progressiv).attr("href", "javascript:goToValutazioneAzienda("+$(xml).find("valutazione_stage").text()+", "+progressiv+")");
            
            if ($(xml).find("valutazione_studente").text() === "-1") 
                $("#editvalutazionestudente"+progressiv).addClass("disabled");
            else
                $("#editvalutazionestudente"+progressiv).attr("href", "javascript:goToValutazioneStudente("+$(xml).find("valutazione_studente").text()+", "+progressiv+")");
            
            if ($(xml).find("azienda").find("id").text().length > 0)
            {
                $("#editinfoazienda"+progressiv).append("<option value=\""+$(xml).find("azienda").find("id").text()+"\"> "+$(xml).find("azienda").find("nome").text()+" </option>");
                $("#editinfoazienda"+progressiv).prop("selectedIndex", 1);
            }
            if ($(xml).find("docente").find("id").text().length > 0)
            {
                $("#editinfodocente"+progressiv).append("<option value=\""+$(xml).find("docente").find("id").text()+"\"> "+$(xml).find("docente").find("cognome").text()+" "+$(xml).find("docente").find("nome").text()+" </option>");
                $("#editinfodocente"+progressiv).prop("selectedIndex", 1);
            }
            if ($(xml).find("tutor").find("id").text().length > 0)
            {
                $("#editinfotutor"+progressiv).append("<option value=\""+$(xml).find("tutor").find("id").text()+"\"> "+$(xml).find("tutor").find("cognome").text()+" "+$(xml).find("tutor").find("nome").text()+" </option>");
                $("#editinfotutor"+progressiv).prop("selectedIndex", 1);
            }
            
            var exclusion = ($(xml).find("docente").find("id").text().length > 0) ? $(xml).find("docente").find("id").text() : null;            
            $.ajax({
                url : 'ajaxOpsPerDettaglioStage/ajaxDocente.php',
                type : 'POST',
                data : {exclusion : exclusion},
                success : function (docs){
                    $(docs).find("docenti").find("docente").each(function (){
                        $("#editinfodocente"+progressiv).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("cognome").text()+" "+$(this).find("nome").text()+" </option>")
                    });
                }
            });
            
            exclusion = ($(xml).find("azienda").find("id").text().length > 0) ? $(xml).find("azienda").find("id").text() : null;            
            $.ajax({
                url : 'ajaxOpsPerDettaglioStage/ajaxAzienda.php',
                type : 'POST',
                data : {exclusion : exclusion},
                success : function (az){
                    $(az).find("aziende").find("azienda").each(function (){
                        $("#editinfoazienda"+progressiv).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>")
                    });
                }
            });
            
            var company = exclusion;
            exclusion = ($(xml).find("tutor").find("id").text().length > 0) ? $(xml).find("tutor").find("id").text() : null;
            if (null !== company)
            {
                $.ajax({
                    url : 'ajaxOpsPerDettaglioStage/ajaxTutor.php',
                    type : 'POST',
                    data : {azienda : company, exclusion: exclusion},
                    success : function (tut){
                        $(tut).find("tutors").find("tutor").each(function (){
                            $("#editinfotutor"+progressiv).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" "+$(this).find("cognome").text()+"</option>")
                        });
                    }
                });
            }
            $("#editinfoazienda"+progressiv).change(function (){
                $(this).css("color", "red");
                if ($(this).val() !== "-1")                    
                {
                    $("#editinfotutor"+progressiv).html("<option value=\"-1\"></option>");
                    $.ajax({
                        url : 'ajaxOpsPerDettaglioStage/ajaxTutor.php',
                        type : 'POST',
                        data : {azienda : $("#editinfoazienda"+progressiv).val(), exclusion: null},
                        success : function (tut){
                            $(tut).find("tutors").find("tutor").each(function (){
                                $("#editinfotutor"+progressiv).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" "+$(this).find("cognome").text()+"</option>")
                            });
                        }
                    });
                }
                else
                {
                    $("#editinfotutor"+progressiv).html("<option value=\"-1\"> </option>");
                }
            });
        }
    });
    
    $("#dettagli"+numberId).prop("disabled", true);
    setOnChangeEvents(progressiv);
    
}

function closeEdit(progressiv)
{
    $("#editinfo"+progressiv).closest("tr").remove();
    $("#dettagli"+(progressiv - 1)).prop("disabled", false);
}

function sendData(progressiv, id_classe_has_stage, id_studente, id_studente_has_stage){    
    tosend = {
        'azienda' : $("#editinfoazienda"+progressiv).val(),
        'tutor' : $("#editinfotutor"+progressiv).val(),
        'docente' : $("#editinfodocente"+progressiv).val(),
        'studente' : id_studente,
        'classe_has_stage' : id_classe_has_stage,
        'studente_has_stage' : id_studente_has_stage,
        'autorizzazione' : $("#editinfoautorizzazione"+progressiv).prop("checked"),
        'visita' : $("#editinfovisita"+progressiv).prop("checked")
    }
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDettaglioStage/ajaxInvia.php',
        cache : false,
        data : tosend,
        success : function (msg)
        {
            if (msg === "ok")
                resetColors(progressiv);
        }
    })
}

function deleteExperience(studente_has_stage){
    if (studente_has_stage !== -1)
    {
        if (confirm("---ATTENZIONE---\nTutte le valutazioni e i registri dell'esperienza di stage verranno eliminati.\n NON C'E' MODO DI ANNULLARE L'AZIONE.\nProcedere?"))
        {
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerDettaglioStage/ajaxDeleteExperience.php',
                data : { 'studente_has_stage' :  studente_has_stage},
                cache : false,
                success : function (msg){
                    location.reload();
                }
            });
        }
    }
    else
    {
        printError("Errore di eliminazione", "<div align='center'>Stage non impostato: impossibile procedere</div>");
    }
}

function goToValutazioneAzienda(id_valutazione_azienda, progressiv)
{
    if (id_valutazione_azienda === "-1") return;
    
    $("#SuperAlert").modal("show");

}
function goToValutazioneStudente(id_valutazione_studente, progressiv)
{
    if (id_valutazione_studente === "-1") return;
    
    $("#SuperAlert").modal("show");
    $("#SuperAlert").find(".modal-title").html("Valutazione dello studente");
    
        $.ajax({
            url : 'ajaxOpsPerDettaglioStage/ajaxGetValutazioneStudente.php',
            type : 'POST',
            cache : false,
            data : {'valutazione_studente' : id_valutazione_studente},
            success : function (xml)
            {
                var modal = $("#SuperAlert").find(".modal-body");
                
                modal.html("<table id=\"valtable\" class=\"table table-bordered\"> <thead> <th>Campo di valutazione</th> <th style=\"text-align : center\">Voto</th> </thead> <tbody> </tbody></table>");
                if ($(xml).find("valutazione").find("gasl").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Gestione dell'ambiente </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("gasl").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Gestione dell'ambiente </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("gasl").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("cc").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Collaborazione e comunicazione</td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("cc").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Collaborazione e comunicazione </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("cc").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("us").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Utilizzo degli strumenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("us").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Utilizzo degli strumenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("us").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("rnv").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Rispetta le norme vigenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("rnv").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Rispetta le norme vigenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("rnv").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("ra").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Rispetta l'ambiente di lavoro </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("ra").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Rispetta l'ambiente di lavoro </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("ra").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("p").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Puntualità </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("p").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Puntualità </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("p").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("ct").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Collaborazione con il tutor </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("ct").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Collaborazione con il tutor </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("ct").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("lr").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Possiede i requisiti lavororativi </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("lr").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Possiede i requisiti lavorativi </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("lr").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("ctec").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Conoscenze tecniche </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("ctec").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Conoscenze tecniche </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("ctec").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione").find("anc").text() >= 6)
                    $("#valtable").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Acquisisce nuove conoscenze </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("anc").text()+" </td> </tr>");
                else
                    $("#valtable").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Acquisisce nuove conoscenze </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione").find("anc").text()+" </td> </tr>");                
                
                modal.append("<b>Commento</b> <textarea class=\"form-control\">"+$(xml).find("valutazione").find("c").text()+"</textarea>");
            }
    });
}

function setOnChangeEvents(progressiv){
    $("#editinfotutor"+progressiv).change(function (){ $(this).css("color", "red"); });
    $("#editinfodocente"+progressiv).change(function (){ $(this).css("color", "red"); });
    $("#editinfovisita"+progressiv).change(function (){ $(this).closest("label").css("color", "red"); });
    $("#editinfoautorizzazione"+progressiv).change(function (){ $(this).closest("label").css("color", "red"); });
}

function resetColors(progressiv){
    $("#editinfotutor"+progressiv).css("color", "#555");
    $("#editinfodocente"+progressiv).css("color", "#555");
    $("#editinfoazienda"+progressiv).css("color", "#555");
    $("#editinfovisita"+progressiv).closest("label").css("color", "#828282");
    $("#editinfoautorizzazione"+progressiv).closest("label").css("color", "#828282");
}
