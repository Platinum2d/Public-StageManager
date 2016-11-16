function openInfo(numberId, id_classe_has_stage, id_studente)
{
    var progressiv = numberId + 1;
    $("<tr> \n\
            <td id=\"editinfo"+progressiv+"\" colspan=\"2\"><div class=\"row\">\n\
                 <div class=\"col col-sm-12\"> \n\
                    <div class=\"row\"> \n\
                       <div class=\"col col-sm-6\"> \n\
                             <label>Azienda</label><select class=\"form-control\" id=\"editinfoazienda"+progressiv+"\"><option value=\"-1\"> </option> </select>\n\
                             <label>Tutor</label><select class=\"form-control\" id=\"editinfotutor"+progressiv+"\"><option value=\"-1\"> </option> </select>\n\
                             <label>Docente</label><select class=\"form-control\" id=\"editinfodocente"+progressiv+"\"><option value=\"-1\"> </option> </select>\n\
                       </div> \n\
                       <div class=\"col col-sm-6\"> \n\
                            <br><div align=\"center\"><input type=\"button\" class=\"btn btn-info\" value=\"Vai alla valutazione dello studente\" /></div> \n\
                            <br><br><div align=\"center\"><input type=\"button\" class=\"btn btn-info\" value=\"Vai alla valutazione dell'azienda\" /></div> \n\
                            \n\
                            <br><div align=\"center\"><label> <input type=\"checkbox\" id=\"editinfovisita"+progressiv+"\"/> Azienda visitata </label></div>\n\
                            <br><div align=\"center\"><label> <input type=\"checkbox\" id=\"editinfoautorizzazione"+progressiv+"\"/> Autorizzazione registro </label></div>\n\
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
        data : { 'studente' : id_studente, 'classe_stage' : id_classe_has_stage },
        cache : false,
        success : function (xml){
            var authorised = $(xml).find("autorizzazione").text();
            
            var visited = $(xml).find("azienda").find("visitata").text();
            
            if (visited === "1")
                $("#editinfovisita"+progressiv).prop("checked", true);
            else
                $("#editinfovisita"+progressiv).prop("checked", false);
            
            if (authorised === "1")
                $("#editinfoautorizzazione"+progressiv).prop("checked", true);
            else
                $("#editinfoautorizzazione"+progressiv).prop("checked", false);
            
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
            else
            {
                $("#editinfotutor"+progressiv).html("<option value=\"-1\"> </option>");
                
                $("#editinfoazienda"+progressiv).change(function (){
                    $.ajax({
                        url : 'ajaxOpsPerDettaglioStage/ajaxTutor.php',
                        type : 'POST',
                        data : {azienda : $("#editinfoazienda"+progressiv).val(), exclusion: null},
                        success : function (tut){
                            alert(tut);
                            $(tut).find("tutors").find("tutor").each(function (){
                                $("#editinfotutor"+progressiv).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" "+$(this).find("cognome").text()+"</option>")
                            });
                        }
                    });
                });
            }
        }
    });
    
    $("#dettagli"+numberId).prop("disabled", true);
}

function closeEdit(progressiv)
{
    $("#editinfo"+progressiv).closest("tr").remove();
    $("#dettagli"+(progressiv - 1)).prop("disabled", false);
}