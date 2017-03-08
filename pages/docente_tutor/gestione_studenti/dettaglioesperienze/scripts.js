$(document).ready(function (){
    $(".tdlink").on("click", function (){
        $(this).find("form[class=\"redirectform\"]").submit();
    });
});

function establishDestination(numberId, id_studente_has_stage){
    if ($("#destination").val() === "valutazionestud") 
        openValutazioneStudente(numberId, id_studente_has_stage);
    else
    {
        if ($("#destination").val() === "valutazioneaz")
            openValutazioneStage(numberId, id_studente_has_stage);
        else
            openRegistro(id_studente_has_stage);
    }
}

function openRegistro(id_studente_has_stage)
{
    var rForm = $("#rForm");
    
    rForm.find("input[name='studente_has_stage']").each(function(){
        $(this).remove();
    });
    
    rForm.append("<input type='hidden' value='"+id_studente_has_stage+"' name='studente_has_stage'>");
    rForm.submit();
}

function openValutazioneStage(numberId, id_studente_has_stage)
{
    $("#SuperAlert").find(".modal-title").html("Valutazione dell'azienda");
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDettaglioEsperienze/ajaxValutazioneStage.php',
        cache : false,
        data : { 'id_studente_has_stage' : id_studente_has_stage },
        success : function (xml)
        {
            $("#SuperAlert").modal("show");
            var modal = $("#SuperAlert").find(".modal-body");
            modal.html("");
            
            $('#SuperAlert').on('hidden.bs.modal', function (e) {
                $("#dettagli"+numberId).prop("disabled", false);
            });
            
            if ($(xml).find("valutazione_stage").length > 0)
            {
                modal.append("<table class=\"table table-bordered\"> <tr name='valutation'> <td><div align=\"center\"><h2>Voto: "+$(xml).find("valutazione_stage").find("voto").text()+"</h2></div></td> </tr> \n\
                                    <tr><td>Commento:<br>"+$(xml).find("valutazione_stage").find("descrizione").text()+" </td></tr>\n\
                                </table>");
                
                if (parseInt($(xml).find("valutazione_stage").find("voto").text()) >= 6)
                    modal.find("table").find("tr[name='valutation']").addClass("success");
                else
                    modal.find("table").find("tr[name='valutation']").addClass("danger");                
            }
            else
            {
                $("#SuperAlert").find(".modal-title").html("Valutazione dell'azienda");
                modal.append("<div align=\"center\"><h4 style=\"color : red\">Lo studente non ha ancora valutato la sua azienda</h4></div>");
            }
        }
    });
}

function openValutazioneStudente(numberId, id_studente_has_stage)
{
    $("#SuperAlert").find(".modal-title").html("Valutazione dello studente");
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDettaglioEsperienze/ajaxValutazioneAzienda.php',
        cache : false,
        data : { 'id_studente_has_stage' : id_studente_has_stage },
        success : function (xml)
        {
            $("#SuperAlert").modal("show");
            
            var modal = $("#SuperAlert").find(".modal-body");
            modal.html("");
            
            $('#SuperAlert').on('hidden.bs.modal', function (e) {
                $("#dettagli"+numberId).prop("disabled", false);
            });
            
            if ($(xml).find("valutazione_studente").length > 0)
            {
                modal.append("<table id=\"valstud\" class=\"table table-bordered\">\n\
                                    <thead><th style=\"text-align : center\">Campo di valutazione</th> <th style=\"text-align : center\">Voto</th></thead>\n\
                                    <tbody> \n\
                                        \n\
                                    </tbody>\n\
                                </table>");
                
                if ($(xml).find("valutazione_studente").find("gasl").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Gestione dell'ambiente </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("gasl").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Gestione dell'ambiente </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("gasl").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("cc").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Collaborazione e comunicazione</td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("cc").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Collaborazione e comunicazione </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("cc").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("us").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Utilizzo degli strumenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("us").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Utilizzo degli strumenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("us").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("rnv").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Rispetta le norme vigenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("rnv").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Rispetta le norme vigenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("rnv").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("ra").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Rispetta l'ambiente di lavoro </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ra").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Rispetta l'ambiente di lavoro </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ra").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("p").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Puntualità </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("p").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Puntualità </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("p").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("ct").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Collaborazione con il tutor </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ct").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Collaborazione con il tutor </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ct").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("lr").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Possiede i requisiti lavororativi </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("lr").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Possiede i requisiti lavorativi </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("lr").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("ctec").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Conoscenze tecniche </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ctec").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Conoscenze tecniche </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ctec").text()+" </td> </tr>");
                
                if ($(xml).find("valutazione_studente").find("anc").text() >= 6)
                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Acquisisce nuove conoscenze </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("anc").text()+" </td> </tr>");
                else
                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Acquisisce nuove conoscenze </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("anc").text()+" </td> </tr>");        
                
                $("<label>Commento Finale:</label><textarea class='form-control'>"+$(xml).find("valutazione_studente").find("c").text()+"</textarea>").insertAfter("#valstud");
            }
            else
            {
                $("#SuperAlert").find(".modal-title").html("Valutazione dello studente");
                modal.append("<div align=\"center\"><h4 style=\"color : red\">L'azienda non ha ancora valutato questo studente</h4></div>");
            }
        }
    });
}


//function openValutazioni(numberId, id_studente_has_stage)
//{
//    $.ajax({
//        type : 'POST',
//        url : 'ajaxOpsPerDettaglioEsperienze/ajaxGetValutations.php',
//        cache : false,
//        data : { 'id_studente_has_stage' : id_studente_has_stage },
//        success : function (xml)
//        {
//            $("#SuperAlert").modal("show");
//            
//            var modal = $("#SuperAlert").find(".modal-body");
//            
//            
//            $('#SuperAlert').on('hidden.bs.modal', function (e) {
//                $("#dettagli"+numberId).prop("disabled", false);
//            });
//            
//            
//            $("#SuperAlert").find(".modal-title").html("Valutazioni di fine esperienza");
//            
//            modal.html("<div class=\"row\">\n\
//                                <div class=\"col col-sm-6\" name=\"studente\">\n\
//                                    <div align=\"center\">Valutazione dello studente</div><br><br>\n\
//                                </div>\n\
//                                <div class=\"col col-sm-6\" name=\"stage\">\n\
//                                    <div align=\"center\">Valutazione dell'azienda</div><br><br>\n\
//                                </div>\n\
//                            </div>");
//            
//            if ($(xml).find("valutazione_studente").length > 0)
//            {
//                var wrapper = modal.find("div[name = 'studente']");
//                
//                
//                wrapper.append("<table id=\"valstud\" class=\"table table-bordered\">\n\
//                                    <thead><th style=\"text-align : center\">Campo di valutazione</th> <th style=\"text-align : center\">Voto</th></thead>\n\
//                                    <tbody> \n\
//                                        \n\
//                                    </tbody>\n\
//                                </table>");
//                
//                if ($(xml).find("valutazione_studente").find("gasl").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Gestione dell'ambiente </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("gasl").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Gestione dell'ambiente </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("gasl").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("cc").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Collaborazione e comunicazione</td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("cc").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Collaborazione e comunicazione </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("cc").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("us").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Utilizzo degli strumenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("us").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Utilizzo degli strumenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("us").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("rnv").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Rispetta le norme vigenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("rnv").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Rispetta le norme vigenti </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("rnv").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("ra").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Rispetta l'ambiente di lavoro </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ra").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Rispetta l'ambiente di lavoro </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ra").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("p").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Puntualità </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("p").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Puntualità </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("p").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("ct").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Collaborazione con il tutor </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ct").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Collaborazione con il tutor </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ct").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("lr").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Possiede i requisiti lavororativi </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("lr").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Possiede i requisiti lavorativi </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("lr").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("ctec").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Conoscenze tecniche </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ctec").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Conoscenze tecniche </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("ctec").text()+" </td> </tr>");
//                
//                if ($(xml).find("valutazione_studente").find("anc").text() >= 6)
//                    $("#valstud").find("tbody").append("<tr style=\"background-color : #B7F4B7\"> <td> Acquisisce nuove conoscenze </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("anc").text()+" </td> </tr>");
//                else
//                    $("#valstud").find("tbody").append("<tr style=\"background-color:rgba(255, 0, 0, 0.3);\"> <td> Acquisisce nuove conoscenze </td> <td style=\"text-align : center\"> "+$(xml).find("valutazione_studente").find("anc").text()+" </td> </tr>");                
//            }
//            else
//            {
//                var wrapper = modal.find("div[name = 'studente']");
//                wrapper.append("<div align=\"center\"><h4 style=\"color : red\">L'azienda non ha ancora valutato questo studente</h4></div>");
//            }
//            
//            
//            
//            
//            if ($(xml).find("valutazione_stage").length > 0)
//            {
//                var wrapper = modal.find("div[name = 'stage']");
//                
//                wrapper.append("<table class=\"table table-bordered\"> <tr> <td><div align=\"center\"><h2>Voto: "+$(xml).find("valutazione_stage").find("voto").text()+"</h2></div></td> </tr> \n\
//                                    <tr><td>Commento: "+$(xml).find("valutazione_stage").find("descrizione").text()+" </td></tr>\n\
//                                </table>");
//            }
//            else
//            {
//                var wrapper = modal.find("div[name = 'stage']");
//                wrapper.append("<div align=\"center\"><h4 style=\"color : red\">Lo studente non ha ancora valutato la sua azienda</h4></div>");
//            }
//        }
//    });
//}