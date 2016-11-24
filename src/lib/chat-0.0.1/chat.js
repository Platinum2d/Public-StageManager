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
    
    if (typeof(localStorage.openedChat) !== "undefined")
    {
        if (localStorage.openedChat === "true") { $("#chat").trigger("click"); }
        else 
        {
            $("#wholechat").html(localStorage.chatCode);
            $('#chatcontent').html('')
            $("#chat").css('opacity','0.4')
            $("#nascondilink").html(' Chat ');
        } 
    }
    else
    {
        $("#wholechat").html(localStorage.chatCode);
        $('#chatcontent').html('')
        $("#chat").css('opacity','0.4')
        $("#nascondilink").html(' Chat ');
    }
});

function hideChat()
{            
    if ($('#nascondilink').html() !== ' Chat ')
    {
        $('#chatcontent').html('')
        //$("#chat").css('opacity','0.4')
        $("#nascondilink").html(' Chat ');
        if (typeof(localStorage.openedChat) === "undefined"){
            localStorage.setItem("openedChat", "false");
        }
        else
        {
            localStorage.openedChat = "false";
        }
    }
}

function fillChat(userType, goback)
{
    if ($('#nascondilink').html() === ' Chat ')
    {
        $("#chat").css('opacity',1);
        $("#nascondilink").html('Nascondi');
        if (typeof(localStorage.chatCode) === "undefined")
        {
            switch (userType){
                case "docente":
                    $.ajax({
                        type : 'POST',
                        url : ""+goback+"src/lib/chat-0.0.1/ajaxOps/docente/ajaxGetUsers.php",
                        cache : false,
                        success : function (xml){
                            $(xml).find("utenti").find("gruppo").each(function (){
                                $("#chatcontent").append("<div style=\"border-top: solid black 1px; margin-bottom: 2px\">\n\
                                <p class=\"chat-user\" onclick=\"createNewDialog(dialogconst+1, '"+$(this).find('studente').find('cognome').text()+" "+$(this).find('studente').find('nome').text()+"')\" > <a style=\"color:white\" href=\"javascript:void(0)\">"+$(this).find('studente').find('cognome').text()+" "+$(this).find('studente').find('nome').text()+"</a> </p>\n\
                                <p class=\"chat-user\" onclick=\"createNewDialog(dialogconst+1, '"+$(this).find('tutor').find('cognome').text()+" "+$(this).find('tutor').find('nome').text()+"')\" > <a style=\"color:white\" href=\"javascript:void(0)\">"+$(this).find('tutor').find('cognome').text()+" "+$(this).find('tutor').find('nome').text()+"</a> </p>\n\
                                <p class=\"chat-user\" onclick=\"createNewDialog(dialogconst+1, '"+$(this).find('azienda').find('nome').text().replace("'","%0")+"')\" > <a style=\"color:white\" href=\"javascript:void(0)\">"+$(this).find('azienda').find('nome').text()+"</a> </p></div>");
                            });
                            localStorage.setItem("chatCode", $("#wholechat").html());
                        }
                    });
                break;
            }
        }
        else
        {
            $("#wholechat").html(localStorage.chatCode);
        }
        
        if (typeof(localStorage.openedChat) === "undefined"){
            localStorage.setItem("openedChat", "true");
        }
        else
        {
            localStorage.openedChat = "true";
        }        
    }
}

function createNewDialog(lastdialog, username){
    if (!$(".dialog-box[name=\""+username+"\"]").length)
    {
        dialogconst += 1;
        username = username.replace("'","%0");
        $("<div class=\"dialog-box\" id=\"dialog"+(lastdialog)+"\" name='"+username+"'> </div>").insertAfter("#chat");
        $("<div class=\"dialog-title\" id=\"dialogtitle"+(lastdialog)+"\"> <div align=\"center\"><span id=\"title"+(lastdialog)+"\" style=\"color:white; font-size : 13.5px\">"+username.replace("%0","'")+"</span> \n\
        <span style=\"color : white\" id=\"removespan"+lastdialog+"\" class=\"glyphicon glyphicon-remove rightAlignment removechat\" onclick=\"deleteDialog("+(lastdialog)+")\"></span> </div> </div>").insertAfter("#dialog"+(lastdialog)+"");
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
}

function deleteDialog(numberId)
{
    $("#dialog"+numberId).remove();
    $("#dialogtitle"+numberId).remove();
    var I;
    for (I = (numberId+1); I <= dialogconst; I++)
    {
        currentmargin = parseInt($("#dialogtitle"+I).css("margin-left").replace("px",""));
        $("#dialog"+I).css("margin-left", currentmargin - $(".dialog-title").width());
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