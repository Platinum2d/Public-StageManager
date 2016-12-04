firstlyselected = null;

$(document).ready(function (){
    
});

function sendData(numberId, id_anno)
{
    tosend = {
        'id' : id_anno,
        'nome' : $("#anno"+numberId).find("td").first().html(),
        'corrente' : $("#anno"+numberId).find("input[type=\"checkbox\"]").prop("checked")
    };
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerAnnoScolastico/ajaxInvia.php',
        data : tosend,
        cache : false,
        success : function (msg){
            if (msg === "ok")
                resetColors(numberId)
        }
    });
}

function resetColors(numberId){
    $("#anno"+numberId).find("td").first().css("color", "#828282")
}

function checkInput(checkbox, firstindex){
    if ($(checkbox).prop("checked"))
    {
        $(".currentcheckbox").prop("checked", false);
        $(checkbox).prop("checked", true);
    }
    else
    {
        $(".currentcheckbox").prop("checked", false);
        $("#anno"+firstindex).find("input[type=\"checkbox\"]").prop("checked", true);
    }
}