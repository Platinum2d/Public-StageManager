var dialogconst = 0;

$(document).ready(function() {
    var winheight = screen.height - $(".navbar-static").height() - 70;
    $("#chat").css("max-height",winheight+"px");
    if (typeof(localStorage.dialogconst) === "undefined"){
        localStorage.setItem("dialogconst", 0);
    }
    else
    {
        dialogconst = +localStorage.getItem('dialogconst');
    }
})

function hideChat()
{            
    if ($('#nascondilink').html() !== ' Chat ')
    {
        $('#chatcontent').html('')
        $("#chat").css('opacity','0.4')
        $("#nascondilink").html(' Chat ');
    }
}

function fillChat()
{
    if ($('#nascondilink').html() === ' Chat ')
    {
        $("#chat").css('opacity',1);
        $("#nascondilink").html('Nascondi');
        if (typeof(localStorage.chatCode) === "undefined")
        {
            $.ajax({
                type : 'POST',
                url : '../../../../pages/admin/inserimento/studenti/ajaxOpsPerStudente/ajaxAzienda.php',
                cache : false,
                success : function (xml){
                    $(xml).find('aziende').find('azienda').each(function () {
                        $("#chatcontent").append("<p style=\"color:black;padding-left: 5px; padding-right: 5px; padding-bottom:10px;padding-top:10px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px; color:white\" onclick=\"createNewDialog(dialogconst+1, '"+$(this).find('nome').text().replace("'","%0")+"')\" > <a style=\"color:white\" href=\"javascript:void(0)\">"+$(this).find('nome').text()+"</a> </p>")
                    })
                }
            })
        }
        else
        {
            $("#wholechat").html(localStorage.chatCode);
        }
    }
}

function createNewDialog(lastdialog, username){
    if (!$(".dialog-box[name=\""+username+"\"]").length)
    {
        alert("entro")
        dialogconst += 1;
        username = username.replace("'","%0");
        $("<div class=\"dialog-box\" id=\"dialog"+(lastdialog)+"\" name='"+username+"'> </div>").insertAfter("#chat");
        $("<div class=\"dialog-title\" id=\"dialogtitle"+(lastdialog)+"\"> <div align=\"center\"><span id=\"title"+(lastdialog)+"\" style=\"color:white; font-size : 12px\">"+username.replace("%0","'")+"</span> \n\
        <span id=\"removespan"+lastdialog+"\" class=\"glyphicon glyphicon-remove rightAlignment removechat\" onclick=\"deleteDialog("+(lastdialog)+")\"></span> </div> </div>").insertAfter("#dialog"+(lastdialog)+"");
        $("#dialogtitle"+(lastdialog)+"").css({'margin-left':($(".dialog-title").width() * dialogconst) , 'bottom':$("#dialog"+(lastdialog)+"").height()})
        $("#dialog"+(lastdialog)+"").css("margin-left",$(".dialog-title").width() * dialogconst);        
        $("#title"+(lastdialog)).css("margin-top",($("#dialogtitle"+(lastdialog)).height()/4));
        $(".removechat").css("margin-top",($("#dialogtitle"+(lastdialog)).height()/4));    
        if (typeof(localStorage.chatCode) !== "undefined")
        {
            localStorage.chatCode = $("#wholechat").html();
        }
        else
        {
            localStorage.setItem("chatCode", $("#wholechat").html());
        }
        localStorage.dialogconst = parseInt(+localStorage.dialogconst + 1);
    }
    else
    {
        alert("non entro")
    }
}

function deleteDialog(numberId)
{
    $("#dialog"+numberId).remove();
    $("#dialogtitle"+numberId).remove();
    var I;
    for (I = (numberId+1); I <= dialogconst; I++)
    {
        currentmargin = parseInt($("#dialogtitle"+I).css("margin-left").replace("px",""));
        $("#dialog"+I).css("margin-left", currentmargin - $(".dialog-box").width());
        $("#dialogtitle"+I).css("margin-left", currentmargin - $(".dialog-title").width());
        
        $("#dialogtitle"+I).attr("id", "dialogtitle"+(I - 1));
        $("#dialog"+I).attr("id", "dialog"+(I - 1));
        $("#title"+I).attr("id", "title"+(I - 1));
        $("#removespan"+I).attr("onclick", "deleteDialog("+(I - 1)+")")
        $("#removespan"+I).attr("id", "removespan"+(I - 1));
    }
    dialogconst -= 1;
    
    if (typeof(localStorage.chatCode) !== "undefined")
    {
        localStorage.chatCode = $("#wholechat").html();
    }
    else
    {
        localStorage.setItem("chatCode", $("#wholechat").html());
    }
    localStorage.dialogconst = parseInt(+localStorage.dialogconst - 1);
}