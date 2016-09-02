String.prototype.isEmpty = function() {
    return (this.length === 0 || !this.trim());
};

var duration = 1500;

$(function (){
    var updater = setInterval(function (){
        var localid = getLastLocalMessageId();
        localid = parseInt(localid.replace("msg", ""));
        $.ajax({
            url : 'ajaxOps/ajaxGetLastMessages.php',
            type : 'POST',
            cache : false,
            data : { 'owner' : $("#senderid").val(), 'lastid' : localid },
            success : function (xml)
            {
                var emptyflag = $(xml).find("empty").text() + '';
                if (emptyflag.length <= 0)
                {
                    $(xml).find("messaggi").find("messaggio").each(function (){
                        var id = $(this).find("id").text();
                        if (!isContainedInReceivedMessages(id))
                        {
                            var messaggio = $(this).find("testo").text();                        
                            $("#messages").append("<div align=\"left\"><p name=\"sentbyother\" id=\"msg"+id+"\" style=\"max-width: 400px\" class=\"triangle-obtuse right\"> "+messaggio+" </p></div>")
                        }
                    });
                }
            },
            error : function (data, textStatus, jqXHR){
            }
        });
    }, 500);
});

function getLastLocalMessageId()
{
    var last = "";
    $("#messages").find("p").each(function (){
        if ($(this).attr("name") === "sentbyother")
            last = $(this).attr("id");
    });
    return (last.isEmpty()) ? "0" : last;
}

function isContainedInReceivedMessages(idtofind){
    $("#messages").find("p").each(function (){
        if ($(this).attr("id") === idtofind)
            return true;
    });
    return false;
}

function send(mittente, destinatario){
    if (!$("#tobesent").val().trim().isEmpty())
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxInsertMessage.php',
            cache : false,
            data : {
                'messaggio' : $("#tobesent").val().trim(),
                'mittente' : mittente,
                'destinatario' : destinatario
            },
            success : function (xml){
                var esito = $(xml).find("esito").text();
                if (esito === "positivo")
                {
                    $.ajax({
                        url : 'ajaxOps/ajaxGetLastMessage.php',
                        type : 'POST',
                        cache : false,
                        data : { 'owner' : $("#receiverid").val()},
                        success : function (xml)
                        {
                            var id = $(xml).find("id").text();
                            var messaggio = $(xml).find("messaggio").text();
                            
                            $("#messages").append("<div align=\"right\"><p name=\"sentbyme\" id=\"msg"+id+"\" style=\"max-width: 400px\" class=\"triangle-obtuse left\"> "+messaggio+" </p></div>");
                        }
                    });
                }
            }
        });
    }
}