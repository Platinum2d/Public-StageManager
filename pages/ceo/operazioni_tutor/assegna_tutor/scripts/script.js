var block = false;

$(document).ready(function (){
    //    $(".glyphicon-pencil").hide();
    //    $("#maintable").find("tr").each(function (){
    //        $(this).mouseover(function (){
    //            $(this).find(".glyphicon-pencil").show(); 
    //        });
    //        
    //        $(this).mouseout(function (){
    //             $(this).find(".glyphicon-pencil").hide();
    //        });
    //    });
});

function editTutor(span, progressiv, id_tutor, studente_has_stage_id)
{ 
    var newhtml = 
            "<div id=\"editthistutor"+progressiv+"\" align=\"center\">\n\
                <select class=\"form-control\" style=\"\"> \n\
                    <option value=\""+id_tutor+"\"> "+$("#edit"+progressiv).find("span[name='tutordata']").text()+" </option>\n\
                </select>\n\
                <div class=\"row\">\n\
                    <div class=\"col col-sm-12\">\n\
                    <div class=\"row\">\n\
                        <div class=\"col col-sm-8\" align=\"left\">\n\
                            <a style=\"color: #828282\" href=\"javascript:freeStudent("+studente_has_stage_id+", 'edit"+progressiv+"', "+progressiv+")\"><u>Togli assegnazione</u></a>\n\
                    </div>\n\
                        <div class=\"col col-sm-4\" align=\"right\">\n\
                            <span style=\"color : green; font-size: 1.2em\" class=\"glyphicon glyphicon-ok leftAlignment\" aria-hidden=\"true\" onclick=\"sendData('edit"+progressiv+"', "+progressiv+", "+studente_has_stage_id+")\" ></span>\n\
                            <span style=\"color : red; font-size: 1.2em\" class=\"glyphicon glyphicon-remove leftAlignment\" aria-hidden=\"true\" onclick=\"closeEdit('edit"+progressiv+"', "+progressiv+")\"></span>\n\
                        </div>\n\
                    </div>\n\
                    </div>\n\
                </div>\n\
            </div>";
    
    $("#edit"+progressiv).hide();
    $(span).closest("td").hide();
    $(span).closest("td").append(newhtml);
    $(span).closest("td").fadeIn("fast");
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxTutors.php',
        data : { 'exclusion' : id_tutor },
        cache : false,
        success : function (xml){
            $(xml).find("tutors").find("tutor").each(function (){
                $("#editthistutor"+progressiv).find("select").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("cognome").text()+" "+$(this).find("nome").text()+" </option>");
            });
        }
    });
}

function closeEdit(spanid, progressiv)
{
    $("#"+spanid).show();
    $("#editthistutor"+progressiv).nextAll("span").remove();
    $("#editthistutor"+progressiv).remove();
}

function sendData(spanid, progressiv, studente_has_stage_id)
{    
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxInvia.php',
        cache : false,
        data : { 'studente_has_stage' : studente_has_stage_id, 'id_tutor' : $("#editthistutor"+progressiv).find("select").val() },
        success : function (msg)
        {
            if (msg === "ok")
            {
                var studente_has_stage = $("#edit"+progressiv).parent().parent().attr("name");
                
                //$("#edit"+progressiv).parents("tr").css("background", "#b4eeb4");
                
                $("#edit"+progressiv).find("span[name='tutordata']").html($("#editthistutor"+progressiv).find("select option:selected").text());
                $("#"+spanid).find(".glyphicon-pencil").attr("onclick", "editTutor($('#"+spanid+"'), "+progressiv+", "+$("#editthistutor"+progressiv).find("select").val()+", "+studente_has_stage+")")
                closeEdit(spanid, progressiv);     
            }
            else
            {
                printError("Errore in fase di invio", "Si è verificato un errore. Si prega di riprovare più tardi.<br>Ci scusiamo per l'inconveniente");
            }
        }
    });
}

function freeStudent(studente_has_stage_id, spanid, progressiv)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxInvia.php',
        cache : false,
        data : { 'studente_has_stage' : studente_has_stage_id, 'id_tutor' : '-1' },
        success : function (msg)
        {
            if (msg === "ok")
            {
                var studente_has_stage = $("#edit"+progressiv).parent().parent().attr("name");
                
                //$("#edit"+progressiv).parents("tr").css("background", "");
                
                $("#edit"+progressiv).find("span[name='tutordata']").html("");
                $("#"+spanid).find(".glyphicon-pencil").attr("onclick", "editTutor($('#"+spanid+"'), "+progressiv+", "+$("#editthistutor"+progressiv).find("select").val()+", "+studente_has_stage+")");
                closeEdit(spanid, progressiv);
            }
            else
            {
                printError("Errore in fase di invio", "Si è verificato un errore. Si prega di riprovare più tardi.<br>Ci scusiamo per l'inconveniente");
            }
        }
    });
}