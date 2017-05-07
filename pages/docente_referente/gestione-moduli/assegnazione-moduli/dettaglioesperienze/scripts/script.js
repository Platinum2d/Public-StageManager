$(document).ready(function (){
});

function openEditModules(id_chs, progressiv)
{
    $("#edit"+progressiv).prop("disabled", true);
    
    $("<tr data-edit-progressiv = '"+progressiv+"'>\n\
        <td colspan='2'>\n\
            <div class='row'>\n\
                <div class='col col-sm-12'>\n\
                    <div class='row'>\n\
                        <div class='col col-sm-6'>\n\
                            Modulo di valutazione dello studente\n\
                            <select id='modulistudente"+progressiv+"' class='form-control'>\n\
                                <option value='-1'></option>\n\
                            </select>\n\
                            <br>\n\
                            <label>Descrizione</label><div id='descrizionestudente"+progressiv+"' style='text-align: justify; text-justify: inter-word;'></div>\n\
                        </div>\n\
                        <div class='col col-sm-6'>\n\
                            Modulo di valutazione dell'azienda\n\
                            <select id='moduliazienda"+progressiv+"' class='form-control'>\n\
                                <option value='-1'></option>\n\
                            </select>\n\
                            <br>\n\
                            <label>Descrizione</label><div id='descrizionestage"+progressiv+"' style='text-align: justify; text-justify: inter-word;'></div>\n\
                            <br>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
            </div>\n\
                            <button onclick='closeEditModules("+progressiv+")' class='btn btn-danger btn-sm rightAlignment margin buttonfix'><span class=\"glyphicon glyphicon-remove spanfix\"></span></button>\n\
                            <button onclick='sendData("+id_chs+", "+progressiv+")' class='btn btn-success btn-sm rightAlignment margin buttonfix'><span class=\"glyphicon glyphicon-ok spanfix\"></span></button>\n\
        </td>\n\
        <td></td>\n\
      </tr>").insertAfter("tr[data-progressiv='"+progressiv+"']");
    
    $("tr[data-edit-progressiv = '"+progressiv+"']").hide();
    $("tr[data-edit-progressiv = '"+progressiv+"']").fadeIn();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStage/getData.php',
        data : {'chs' : id_chs},
        cache : false,
        success : function (xml)
        {
            var id_stage = $(xml).find("modulo_valutazione_stage").find("id").text();
            var nome_stage = $(xml).find("modulo_valutazione_stage").find("nome").text();
            var descrizione_stage = $(xml).find("modulo_valutazione_stage").find("descrizione").text();
            var id_studente = $(xml).find("modulo_valutazione_studente").find("id").text();
            var nome_studente = $(xml).find("modulo_valutazione_studente").find("nome").text();
            var descrizione_studente = $(xml).find("modulo_valutazione_studente").find("descrizione").text();
            
            $("tr[data-progressiv='"+progressiv+"']").attr("data-val-stage", id_stage);
            $("tr[data-progressiv='"+progressiv+"']").attr("data-val-studente", id_studente);
            $("#descrizionestudente"+progressiv).html(descrizione_studente);
            $("#descrizionestage"+progressiv).html(descrizione_stage);
            
            if (id_stage.length > 0) $("#moduliazienda"+progressiv).append("<option selected='true' value='"+id_stage+"'>"+nome_stage+"</option>");
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerStage/ajaxGetValutazioneStageModules.php',
                data : {'exception' : id_stage},
                cache : false,
                success : function (xml)
                {
                    $(xml).find("moduli").find("modulo").each(function (){
                        var id = $(this).find("id").text();
                        var nome = $(this).find("nome").text();
                        var descrizione = $(this).find("descrizione").text();
                        
                        $("#moduliazienda"+progressiv).append("<option value='"+id+"'>"+nome+"</option>");
                    });
                }
            }); 
            
            if (id_studente.length > 0) $("#modulistudente"+progressiv).append("<option selected='true' value='"+id_studente+"'>"+nome_studente+"</option>");
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerStage/ajaxGetValutazioneStudenteModules.php',
                data : {'exception' : id_studente},
                cache : false,
                success : function (xml)
                {
                    $(xml).find("moduli").find("modulo").each(function (){
                        var id = $(this).find("id").text();
                        var nome = $(this).find("nome").text();
                        var descrizione = $(this).find("descrizione").text();
                        
                        $("#modulistudente"+progressiv).append("<option value='"+id+"'>"+nome+"</option>");
                    });
                }
            });
            
            $("#modulistudente"+progressiv).change(function (){
                $(this).css("color", "red");
                
                $("#descrizionestudente"+progressiv).css("color", "red");
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOpsPerStage/ajaxGetDescrizione.php',
                    data : {'id' : $(this).val(), 'tb' : 'studente'},
                    cache : false,
                    success : function (desc)
                    {
                        $("#descrizionestudente"+progressiv).html(desc);
                    }
                });
            });
            
            $("#moduliazienda"+progressiv).change(function (){
                $(this).css("color", "red");
                
                $("#descrizionestage"+progressiv).css("color", "red");
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOpsPerStage/ajaxGetDescrizione.php',
                    data : {'id' : $(this).val(), 'tb' : 'stage'},
                    cache : false,
                    success : function (desc)
                    {
                        $("#descrizionestage"+progressiv).html(desc);
                    }
                });
            });
        }
    });
}

function closeEditModules(progressiv)
{
    $("tr[data-edit-progressiv = '"+progressiv+"']").remove();
    $("#edit"+progressiv).prop("disabled", false);
}

function sendData(id_chs, progressiv)
{
    tosend = {
        'modulo_stage' : $("#moduliazienda"+progressiv).val(),
        'modulo_studente' : $("#modulistudente"+progressiv).val(),
        'chs' : id_chs
    };
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStage/ajaxEditModules.php',
        data : tosend,
        cache : false,
        success : function (msg)
        {
            if (msg === "ok")
                resetColors(progressiv);
            else
                printError("Errore di aggiornamento", "<div align='center'>Si è verificato un errore in fase di aggiornamento<br>Si prega di riprovare</div>")
        }
    });
}

function resetColors(progressiv)
{
    $("#descrizionestage"+progressiv).css("color", "#828282");
    $("#descrizionestudente"+progressiv).css("color", "#828282");
    $("#moduliazienda"+progressiv).css("color", "#828282");
    $("#modulistudente"+progressiv).css("color", "#828282");
}
