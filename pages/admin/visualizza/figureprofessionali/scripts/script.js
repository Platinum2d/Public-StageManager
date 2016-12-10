function sendData(numberId, id_figura)
{
    tosend = {
        'id' : id_figura,
        'nome' : $("#figura"+numberId).find("td").first().html()
    };
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerFiguraProfessionale/ajaxInvia.php',
        data : tosend,
        cache : false,
        success : function (msg){
            if (msg === "ok")
                resetColors(numberId)
        }
    });
}

function resetColors(numberId){
    $("#figura"+numberId).find("td").css("color", "#828282")
}