$(document).ready(function (){
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
});

function sendData(numberId, id_stage)
{
    tosend = {
        'id' : id_stage,
        'inizio' : $("#stage"+numberId).find("input[name='datawrapper']").val(),
        'durata' : $("#stage"+numberId).find("td[name='durata']").html()
    };
    
    if (tosend.inizio.trim() === "" || typeof(tosend.inizio.trim()) === "undefined" || tosend.durata.trim() === "" || typeof(tosend.durata.trim()) === "undefined")
        return;
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStage/ajaxInvia.php',
        data : tosend,
        cache : false,
        success : function (msg){
            if (msg === "ok")
                resetColors(numberId);
        }
    });
}

function resetColors(numberId){
    $("#stage"+numberId).find("input[name='datawrapper']").css("color", "#828282");
    $("#stage"+numberId).find("td[name='durata']").css("color", "#828282");
}