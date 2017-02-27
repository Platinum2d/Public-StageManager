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
            <select class=\"form-control\" style=\"width : 75%\"> \n\
                <option value=\""+id_tutor+"\"> "+$("#edit"+progressiv).find("span[name='tutordata']").text()+" </option>\n\
            </select></div>\n\
            <span style=\"color : green; font-size: 1.2em\" class=\"glyphicon glyphicon-ok leftAlignment\" aria-hidden=\"true\" onclick=\"sendData('edit"+progressiv+"', "+progressiv+", "+studente_has_stage_id+")\" ></span>\n\
            <span style=\"color : red; font-size: 1.2em\" class=\"glyphicon glyphicon-remove leftAlignment\" aria-hidden=\"true\" onclick=\"closeEdit('edit"+progressiv+"', "+progressiv+")\"></span>";
    
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
            var studente_has_stage = $("#edit"+progressiv).parent().parent().attr("name");
            
            
            $("#edit"+progressiv).find("span[name='tutordata']").html($("#editthistutor"+progressiv).find("select option:selected").text());
            $("#"+spanid).find(".glyphicon-pencil").attr("onclick", "editTutor($('#"+spanid+"'), "+progressiv+", "+$("#editthistutor"+progressiv).find("select").val()+", "+studente_has_stage+")")
            closeEdit(spanid, progressiv);            
        }
    });
}