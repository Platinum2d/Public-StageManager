$(document).ready(function (){
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
});

function sendData(numberId, id_settore)
{
    tosend = {
        'id' : id_settore,
        'indirizzo' : $("#settore"+numberId).find("td[name='indirizzo']").html(),
        'settore' : $("#settore"+numberId).find("td[name='settore']").html()
    };
    
    if (tosend.indirizzo.trim() === "" || typeof(tosend.indirizzo.trim()) === "undefined" || tosend.settore.trim() === "" || typeof(tosend.settore.trim()) === "undefined")
        return;
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerSettore/ajaxInvia.php',
        data : tosend,
        cache : false,
        success : function (msg){
            if (msg === "ok")
                resetColors(numberId);
        }
    });
}

function resetColors(numberId){
    $("#settore"+numberId).find("td[name='indirizzo']").css("color", "#828282");
    $("#settore"+numberId).find("td[name='settore']").css("color", "#828282");
}